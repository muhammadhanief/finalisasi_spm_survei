<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\Dimension;
use App\Models\QuestionType;
use App\Models\Subdimension;
use App\Models\AnswerOption;
use App\Models\AnswerOptionValue;
use App\Models\TargetResponden;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Role::create(['name' => 'SuperAdmin']);
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'User']);
        Role::create(['name' => 'Operator']);
        Role::create(['name' => 'Dosen']);
        Role::create(['name' => 'Mahasiswa']);
        Role::create(['name' => 'Tenaga kependidikan']);
        Role::create(['name' => 'Pengguna lulusan']);
        Role::create(['name' => 'Lulusan']);



        // seeder untuk question type
        QuestionType::create([
            'name' => 'Umum',
        ]);

        QuestionType::create([
            'name' => 'Harapan',
        ]);
        QuestionType::create([
            'name' => 'Kenyataan',
        ]);



        // Seeder untuk dimensi
        // Dimension::create([
        //     'name' => 'Keandalan',
        // ]);
        // Dimension::create([
        //     'name' => 'Daya Tangkap',
        // ]);
        // Dimension::create([
        //     'name' => 'Kepastian',
        // ]);
        // Dimension::create([
        //     'name' => 'Empati',
        // ]);
        // Dimension::create([
        //     'name' => 'Transparan',
        // ]);

        // $a = Dimension::create([
        //     'name' => 'Kualitas Layanan',
        // ]);
        // $a->assignRole('Admin');

        // $b = Subdimension::create([
        //     'name' => 'Keandalan',
        //     'dimension_id' => 1,

        // ]);
        // $b->assignRole('Admin');
        // Subdimension::create([
        //     'name' => 'Daya Tangkap',
        //     'dimension_id' => 1,

        // ]);
        // Subdimension::create([
        //     'name' => 'Kepastian',
        //     'dimension_id' => 1,

        // ]);
        // Subdimension::create([
        //     'name' => 'Empati',
        //     'dimension_id' => 1,

        // ]);

        // AnswerOption::create([
        //     'name' => 'Jenis Kelamin',
        //     'type' => 'radio',
        // ]);
        // AnswerOptionValue::create([
        //     'name' => 'Laki-laki',
        //     'answer_option_id' => 1,
        //     'value' => 1,
        // ]);
        // AnswerOptionValue::create([
        //     'name' => 'Perempuan',
        //     'answer_option_id' => 1,
        //     'value' => 2,
        // ]);

        // AnswerOption::create([
        //     'name' => 'Pendidikan',
        //     'type' => 'radio',
        // ]);

        // AnswerOptionValue::create([
        //     'name' => 'SMA',
        //     'answer_option_id' => 2,
        //     'value' => 1,
        // ]);
        // AnswerOptionValue::create([
        //     'name' => 'D3',
        //     'answer_option_id' => 2,
        //     'value' => 2,
        // ]);
        // AnswerOptionValue::create([
        //     'name' => 'S1',
        //     'answer_option_id' => 2,
        //     'value' => 3,
        // ]);
        // AnswerOption::create([
        //     'name' => 'Penliaian 4 Opsi',
        //     'type' => 'radio'
        // ]);
        // AnswerOptionValue::create([
        //     'name' => 'Sangat Baik',
        //     'answer_option_id' => 3,
        //     'value' => 1,
        // ]);
        // AnswerOptionValue::create([
        //     'name' => 'Baik',
        //     'answer_option_id' => 3,
        //     'value' => 2,
        // ]);
        // AnswerOptionValue::create([
        //     'name' => 'Cukup',
        //     'answer_option_id' => 3,
        //     'value' => 3,
        // ]);
        // AnswerOptionValue::create([
        //     'name' => 'Kurang',
        //     'answer_option_id' => 3,
        //     'value' => 4,
        // ]);

        // TargetResponden::create([
        //     'role_id' => 1,
        //     'unique_code' => 'haniefm19D27',
        //     'name' => 'Muhammad Hanief',
        //     'email' => 'haniefm19@gmail.com',
        //     'type' => 'individual'
        // ]);
        // TargetResponden::create([
        //     'role_id' => 1,
        //     'unique_code' => 'ladisaD27',
        //     'name' => 'Ladisa Busaina',
        //     'email' => 'ladisa@gmail.com',
        //     'type' => 'group'
        // ]);
    }
}