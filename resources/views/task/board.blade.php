@extends('layouts.app')

@section('content')
<style>
    .kanban-board {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        padding: 2rem;
    }
    .kanban-column {
        flex: 1;
        background-color: #f8f9ff;
        border-radius: 0.5rem;
        padding: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        min-height: 300px;
    }
    .kanban-header {
        background-color: #6c3ef6;
        color: white;
        font-weight: bold;
        padding: 0.5rem;
        border-radius: 0.375rem;
        text-align: center;
        margin-bottom: 1rem;
    }
    .task-card {
        background-color: #fff;
        padding: 1rem;
        margin-bottom: 0.75rem;
        border-radius: 0.375rem;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
        cursor: grab;
    }
    .task-card.bg-purple-200 {
        cursor: grab;
    }
    .footer {
        background-color: #111;
        color: #fff;
        text-align: center;
        padding: 1rem;
    }
</style>

<div class="text-center py-6 bg-[#6c3ef6] text-white text-2xl font-bold">LombaKuy Review Tugas Lomba Board</div>

<div class="kanban-board">
    <div class="kanban-column">
        <div class="kanban-header">Task Template</div>
        <div id="template-task">
            @foreach (["Research Lomba", "Brainstorming", "Buat Materi Lomba", "Persiapan Tools Lomba", "Persiapan Logistik"] as $template)
                <div class="task-card bg-purple-200" draggable="true" data-title="{{ $template }}" id="template-{{ \Illuminate\Support\Str::slug($template) }}">{{ $template }}</div>
            @endforeach
        </div>
    </div>

    @foreach (["To Do", "In Progress", "In Review", "Done"] as $status)
        <div class="kanban-column" data-status="{{ $status }}" ondragover="allowDrop(event)" ondrop="drop(event)">
            <div class="kanban-header">{{ $status }}</div>
            <div class="task-list min-h-[200px]" id="{{ strtolower(str_replace(' ', '-', $status)) }}">
                {{-- Tasks akan dimanage via JS --}}
            </div>
        </div>
    @endforeach
</div>

<!-- Modal -->
<div id="taskModal" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-xl font-semibold mb-4">Detail Tugas: <span id="modalTaskTitle"></span></h2>
        <form id="taskForm">
            <input type="hidden" id="taskStatus" name="status">
            <input type="hidden" id="taskTitleInput" name="title">
            <input type="hidden" id="taskIdInput" name="task_id">
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Author</label>
                <input type="text" id="taskAuthor" name="author" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Tanggal Mulai</label>
                <input type="date" id="taskStart" name="start_date" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Tanggal Selesai</label>
                <input type="date" id="taskEnd" name="end_date" class="w-full border rounded p-2" required>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()" class="bg-gray-300 px-4 py-2 rounded">Batal</button>
                <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>


<script>
    let currentDraggedTask = null; // Menyimpan elemen task yang sedang di-drag
    let isFromTemplate = false; // Menandakan apakah task berasal dari template

    // Set semua template task bisa drag
    function initTemplateDrag() {
        document.querySelectorAll('#template-task .task-card').forEach(el => {
            el.addEventListener('dragstart', e => {
                currentDraggedTask = e.target;
                isFromTemplate = true;
                e.dataTransfer.setData('text/plain', e.target.dataset.title);
            });
        });
    }

    // Semua task di kolom status bisa drag juga (task aktif)
    function initTaskDrag() {
        document.querySelectorAll('.kanban-column .task-list .task-card').forEach(el => {
            el.setAttribute('draggable', 'true');
            el.style.cursor = 'grab';
            el.addEventListener('dragstart', e => {
                currentDraggedTask = e.target;
                isFromTemplate = false;
                e.dataTransfer.setData('text/plain', e.target.querySelector('.font-semibold').textContent);
                e.dataTransfer.setData('task-id', e.target.dataset.id);
            });
        });
    }

    // Biar bisa drop di kolom status
    function allowDrop(e) {
        e.preventDefault();
    }

    // Saat drop di kolom status
    function drop(e) {
        e.preventDefault();
        const status = e.currentTarget.dataset.status;
        if (!currentDraggedTask) return;

        if (isFromTemplate) {
            // Drag dari template ke status baru
            const title = currentDraggedTask.dataset.title;
            openModal(status, title, null);
        } else {
            // Drag dari kolom lain ke kolom status baru (update status dan edit detail)
            const taskCard = currentDraggedTask;
            const taskId = taskCard.dataset.id;
            const title = taskCard.querySelector('.font-semibold').textContent;
            openModal(status, title, taskId, taskCard);
        }
    }

    // Buka modal dan isi data jika ada (taskId, taskCard)
    function openModal(status, title, taskId = null, taskCard = null) {
        document.getElementById('taskStatus').value = status;
        document.getElementById('modalTaskTitle').textContent = title;
        document.getElementById('taskTitleInput').value = title;
        document.getElementById('taskIdInput').value = taskId || '';

        if (taskCard) {
            // Ambil data author dan tanggal dari card lama
            const info = taskCard.querySelector('.text-sm').innerHTML.split('<br>');
            document.getElementById('taskAuthor').value = info[0] || '';
            document.getElementById('taskStart').value = info[1]?.split(' - ')[0] || '';
            document.getElementById('taskEnd').value = info[1]?.split(' - ')[1] || '';
        } else {
            // Baru dari template, reset input
            document.getElementById('taskAuthor').value = '';
            document.getElementById('taskStart').value = '';
            document.getElementById('taskEnd').value = '';
        }

        document.getElementById('taskModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('taskModal').classList.add('hidden');
        currentDraggedTask = null;
    }

    // Simpan task ke kolom sesuai input modal
    document.getElementById('taskForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const status = document.getElementById('taskStatus').value;
        const title = document.getElementById('taskTitleInput').value;
        const author = document.getElementById('taskAuthor').value.trim();
        const start = document.getElementById('taskStart').value;
        const end = document.getElementById('taskEnd').value;
        const taskId = document.getElementById('taskIdInput').value;

        if (!author || !start || !end) {
            alert('Mohon isi semua data dengan lengkap.');
            return;
        }

        const taskList = document.querySelector(`.kanban-column[data-status="${status}"] .task-list`);

        if (isFromTemplate) {
            // Buat task baru dari template
            const taskCard = document.createElement('div');
            taskCard.classList.add('task-card', 'bg-white');
            // Generate id unik sementara (bisa ganti pake backend)
            const newId = 'task-' + Date.now();
            taskCard.dataset.id = newId;
            taskCard.innerHTML = `
                <div class="font-semibold">${title}</div>
                <div class="text-sm text-gray-500">${author}<br>${start} - ${end}</div>
            `;
            taskList.appendChild(taskCard);

            // Hilangkan dari template
            currentDraggedTask.remove();

            // Inisialisasi drag event untuk task baru
            initTaskDrag();

        } else {
            // Update task lama, pindah kolom
            // Cari task lama
            let taskCard = currentDraggedTask;
            taskCard.dataset.id = taskId;
            taskCard.querySelector('.font-semibold').textContent = title;
            taskCard.querySelector('.text-sm').innerHTML = `${author}<br>${start} - ${end}`;

            // Pindah ke kolom baru
            taskList.appendChild(taskCard);
        }

        closeModal();
    });

    // Init drag untuk template dan task aktif di load pertama
    window.onload = () => {
        initTemplateDrag();
        initTaskDrag();
    };
</script>
@endsection
