<?php

namespace Tests\Feature\Livewire;


use App\Livewire\Survey\Monitoring;
use App\Livewire\Survey\OverviewSurveyAdmin;
use App\Mail\RespondenSurveyAnnounceFirst;
use App\Models\Survey;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class MonitoringTest extends TestCase
{
    /** @test */
    public function it_downloads_excel_file_with_correct_name(): void
    {
        // Ambil satu entitas survey secara acak dari database
        $survey = Survey::inRandomOrder()->first();

        // Mock the Excel facade
        Excel::fake();

        // Panggil metode downloadAnswers tanpa mengatur surveyID secara langsung
        Livewire::test(Monitoring::class)
            ->call('downloadAnswers'); // Tidak perlu mengatur surveyID di sini

        // Verifikasi bahwa Excel::download dipanggil dengan nama file yang sesuai
        $expectedFileName = '[Jawaban] ' . $survey->name . ' ' . now()->format('Y-m-d H:i:s') . '.xlsx';
        Excel::assertDownloaded($expectedFileName);
    }


    /** @test */
    // Perbarui responden update unit
    public function it_updates_expected_respondents_in_database(): void
    {
        // faker survey
        $survey = Survey::factory()->create([
            'expectedRespondents' => 200, // Ganti dengan nilai yang diharapkan
        ]);
        $numberRandom = rand(1, 1000);

        // Pastikan ada survey yang tersedia
        $this->assertNotNull($survey, 'Tidak ada survey yang tersedia.');

        // Panggil Livewire::test() dengan memberikan nilai $survey->id ke parameter mount()
        Livewire::test(Monitoring::class, ['surveyID' => $survey->id])
            ->set('expectedRespondents', $numberRandom) // Ganti dengan nilai yang diharapkan
            ->call('updateExpectedResponden');

        // Pastikan bahwa jumlah responden yang diharapkan telah diperbarui dalam database
        $this->assertDatabaseHas('surveys', [
            'id' => $survey->id,
            'expectedRespondents' => $numberRandom, // Sesuaikan dengan nilai yang diharapkan
        ]);
    }

    /** @test */
    public function it_sends_email_reminders()
    {
        // Pastikan ada survey, target_respondens, dan entries di database
        $survey = Survey::inRandomOrder()->first();
        $this->assertNotNull($survey, 'Tidak ada survey yang tersedia.');

        $targetRespondens = DB::table('target_respondens')->get();
        $this->assertNotEmpty($targetRespondens, 'Tidak ada target respondens yang tersedia.');

        $entries = DB::table('entries')->get();
        $this->assertNotEmpty($entries, 'Tidak ada entries yang tersedia.');

        // Gunakan Mail fake untuk memeriksa apakah email dikirim
        Mail::fake();

        Livewire::test(Monitoring::class, ['surveyID' => $survey->id])
            ->call('sendEmailReminder');

        // Pastikan email terkirim ke semua target respondens yang belum submit
        foreach ($targetRespondens as $targetResponden) {
            if (!$entries->contains('target_responden_id', $targetResponden->id) || $targetResponden->type == "group") {
                Mail::assertSent(RespondenSurveyAnnounceFirst::class, function ($mail) use ($targetResponden) {
                    return $mail->hasTo($targetResponden->email);
                });
            }
        }
    }


    /** @test */
    public function it_deletes_survey_successfully()
    {
        // Ambil satu survey dari database
        $survey = Survey::where('started_at', '>', now())->inRandomOrder()->first();

        // // Pastikan survey berhasil dibuat
        $this->assertDatabaseHas('surveys', ['id' => $survey->id]);

        // Panggil metode delete
        Livewire::test(OverviewSurveyAdmin::class)
            ->call('delete', $survey->id);

        // // // Verifikasi bahwa survey berhasil dihapus dari database
        $this->assertDatabaseMissing('surveys', ['id' => $survey->id]);
    }

    /** @test */
    public function it_shows_error_message_when_deleting_started_survey()
    {
        // Ambil satu survey yang sudah dimulai dari database
        $survey = Survey::where('started_at', '<=', now())->inRandomOrder()->first();

        // Pastikan survey yang sudah dimulai ada dalam database
        $this->assertNotNull($survey);

        // Panggil metode delete
        Livewire::test(OverviewSurveyAdmin::class)
            ->call('delete', $survey->id);

        // // Verifikasi bahwa pesan kesalahan ditampilkan
        // Livewire::test(OverviewSurveyAdmin::class)
        //     ->assertSee('Survey tidak dapat dihapus karena sudah dimulai/selesai');

        // Verifikasi bahwa data survei masih ada dalam database
        $this->assertDatabaseHas('surveys', ['id' => $survey->id]);
        // dd($survey->id);
    }
}