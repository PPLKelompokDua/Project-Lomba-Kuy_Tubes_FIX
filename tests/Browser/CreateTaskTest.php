<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTaskTest extends DuskTestCase
{
    use RefreshDatabase;

    public function testUserCanCreateNewTask()
    {
        $this->browse(function (Browser $browser) {
            $browser
                // 1. Buka halaman task management
                ->visit('/task-management')

                // 2. Tunggu sampai field title muncul
                ->waitFor('input[name=title]', 5)

                // 3. Isi form
                ->type('title', 'Tugas UTS DWBI')
                ->type('description', 'Mengerjakan soal OLAP SQL untuk PT. Konohamart')
                ->type('due_date', '2025-05-06')

                // 4. Pilih status "pending" (sesuai value di <option value="pending">)
                ->select('status', 'pending')

                // 5. Submit form
                ->press('Create Task')

                // 6. Tunggu sampai redirect dan muncul teks baru
                ->waitForText('Tugas UTS DWBI', 5)
                ->assertSee('Tugas UTS DWBI');
        });
    }
}
