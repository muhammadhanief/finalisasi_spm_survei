<?php

namespace App\Livewire\Survey;

use App\Exports\AnswersExport;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Entry;
use App\Models\TargetResponden;
use App\Models\Survey;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use App\Mail\RespondenSurveyAnnounceFirst;
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Validate;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Auth\Events\Validated;

class Monitoring extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $surveyID;
    public $dataChartIndividual = [];
    public $search = '';
    public $lastUpdatedTime;
    #[Validate]
    public $expectedRespondents;
    #[Validate(['required'])]
    public $startAt;
    #[Validate(['required'])]
    public $endAt;
    public $qrCodeUrl;
    public $surveyName;
    public $survey;
    public $mailer_narration;
    public $uuid;

    // untuk modal mailer

    // public $roleRespondentOnSurvei;
    // public $targetRespondens;

    // public function qrCode()
    // {
    //     // dd($this->surveyID);
    //     $url = route('survey.fill', ['surveyID' => $this->surveyID]);

    //     // Generate QR code
    //     $qrCode = QrCode::size(200)
    //         ->backgroundColor(255, 255, 0)
    //         ->color(0, 0, 255)
    //         ->margin(1)
    //         ->generate($url);
    //     // Simpan URL QR code untuk ditampilkan di view
    //     $this->qrCodeUrl = 'data:image/png;base64,' . base64_encode($qrCode);
    // }

    public function updateStartAt()
    {
        $this->validate([
            'startAt' => 'required',
        ]);
        $survey = Survey::find($this->surveyID);
        $survey->started_at = $this->startAt;
        $survey->save();
        $this->alert('success', 'Sukses!', [
            'position' => 'center',
            'timer' => 2000,
            'toast' => true,
            'text' => 'Waktu mulai survei berhasil diperbaharui.',
        ]);
    }

    public function updateEndAt()
    {
        $this->validate([
            'endAt' => 'required',
        ]);
        $survey = Survey::find($this->surveyID);
        $survey->ended_at = $this->endAt;
        $survey->save();
        $this->alert('success', 'Sukses!', [
            'position' => 'center',
            'timer' => 2000,
            'toast' => true,
            'text' => 'Waktu berakhir survei berhasil diperbaharui.',
        ]);
    }

    public function rules()
    {
        return [
            'expectedRespondents' => 'required|numeric',
        ];
    }

    public function getDataChart()
    {
        $submittedIndividual = Entry::where('survey_id', $this->surveyID)
            // ->whereHas('targetResponden', function ($query) {
            //     $query->where('type', 'individual');
            // })
            ->count();
        $survey = Survey::find($this->surveyID);
        // $totalRespondenIndividual = TargetResponden::whereIn('role_id', json_decode($survey->role_id))
        //     ->where('type', 'individual')
        //     ->count();
        $totalRespondenIndividual = $this->expectedRespondents;

        // Hitung jumlah yang belum mengisi
        $belumMengisi = $totalRespondenIndividual - $submittedIndividual;

        // Jika jumlah yang belum mengisi menjadi negatif, atur menjadi 0
        $belumMengisi = max(0, $belumMengisi);

        // Assign data ke dalam array
        $this->dataChartIndividual = [
            'Telah Mengisi' => $submittedIndividual,
            'Belum Mengisi' => $belumMengisi,
        ];

        $this->currentRespondentsPercent = $totalRespondenIndividual == 0 ? 0 : round($submittedIndividual / $totalRespondenIndividual * 100);
        $this->afterRespondentsPercent = $this->currentRespondentsPercent;
        $this->currentRespondentsCount = $submittedIndividual;
        $this->fullyData = $this->expectedRespondents - $submittedIndividual;
    }

    public function getUpdatedDataChart()
    {
        $this->getDataChart();
        $this->dispatch('chartUpdated', $this->dataChartIndividual);
    }

    public function updateTable()
    {
        $this->render();
    }

    public function updateAll()
    {
        $this->updateTable();
        // ambil waktu terakhir update
        $this->lastUpdatedTime = now()->format('H:i:s');
        $this->getUpdatedDataChart();
    }

    // Properti untuk melacak progres
    public $sendingProgress = 0;
    public $totalEmails = 0;
    public $successCount = 0;
    public $errorCount = 0;
    public $errorMessage = '';

    // Pro

    public function updateExpectedResponden()
    {
        $this->validate([
            'expectedRespondents' => 'required|numeric',
        ]);
        $survey = Survey::find($this->surveyID);
        $survey->expectedRespondents = $this->expectedRespondents;
        $survey->save();
        $this->getDataChart();
        $this->dispatch('chartUpdated', $this->dataChartIndividual);

        $this->alert('success', 'Sukses!', [
            'position' => 'center',
            'timer' => 2000,
            'toast' => true,
            'text' => 'Jumlah target responden berhasil diperbaharui.',
        ]);
    }

    // public function sendEmailReminder()
    // {
    // $survey = Survey::find($this->surveyID);
    // $roleIds = json_decode($survey->role_id, true);

    // $survey->mailer_narration = $this->mailer_narration;
    // $survey->save();


    // $this->totalEmails = count($targetRespondens);

    // $error = [];

    // foreach ($targetRespondens as $targetResponden) {
    //     if ($targetResponden->submitted == false || $targetResponden->type == "group") {
    //         try {
    //             Mail::to($targetResponden->email)->send(new RespondenSurveyAnnounceFirst([
    //                 'email' => $targetResponden->email,
    //                 'name' => $targetResponden->name,
    //                 'unique_code' => $targetResponden->unique_code,
    //                 'uuid' => $this->uuid,
    //                 // 'survey_id' => $this->surveyID,
    //                 'end_at' => $this->endAt,
    //                 'survey_title' => Survey::find($this->surveyID)->name,
    //                 'mailer_narration' => $this->mailer_narration,
    //             ]));

    //             // Update progres
    //             $this->successCount++;
    //         } catch (\Exception $e) {
    //             $error[] = $e->getMessage();
    //             // Update progres
    //             $this->errorCount++;
    //             $this->errorMessage = $e->getMessage();
    //         }

    //         // Update progres
    //         $this->sendingProgress = ($this->successCount + $this->errorCount) / $this->totalEmails * 100;
    //     }
    // }

    // // Setelah selesai, tampilkan alert berdasarkan hasil
    // if (count($error) == 0) {
    //     $this->alert('success', 'Sukses!', [
    //         'position' => 'center',
    //         'timer' => 2000,
    //         'toast' => true,
    //         'text' => 'Email sukses dikirim.',
    //     ]);
    //     $this->reset('sendingProgress', 'totalEmails', 'successCount', 'errorCount', 'errorMessage');
    // } else {
    //     $this->alert('error', 'Gagal!', [
    //         'position' => 'center',
    //         'timer' => 2000,
    //         'toast' => true,
    //         'text' => 'Gagal mengirim email: ' . $this->errorMessage,
    //     ]);
    // }
    // }

    public function mount($surveyID)
    {
        $this->surveyID = $surveyID;
        $this->uuid = Survey::find($surveyID)->uuid;
        $this->surveyName = Survey::find($surveyID)->name;
        $this->survey = Survey::find($surveyID);
        $this->mailer_narration = Survey::find($surveyID)->mailer_narration;
        $expectedRespondentsTemp = Survey::find($surveyID)->expectedRespondents;
        // $role_id = json_decode(Survey::find($surveyID)->role_id, true);
        // $this->targetRespondens = TargetResponden::whereIn('role_id', $role_id)->get();
        // dd($targetRespondens);
        if ($expectedRespondentsTemp == null) {
            $this->expectedRespondents = 0;
        } else {
            $this->expectedRespondents = $expectedRespondentsTemp;
        }
        $this->startAt = Survey::find($surveyID)->started_at;
        $this->endAt = Survey::find($surveyID)->ended_at;
        $this->getDataChart();
        $this->lastUpdatedTime = now()->format('H:i:s');
    }


    public function copyLink()
    {
        $this->dispatch('copyLink', 'google.com');
        $this->alert('success', 'Tautan berhasil disalin!', [
            'position' => 'center',
            'timer' => 2000,
            'toast' => true,
            // 'text' => 'Link berhasil disalin.',
        ]);
    }

    public function downloadAnswers()
    {
        $survey = Survey::find($this->surveyID);
        $surveyName = $survey ? $survey->name : 'unknown';
        $surveyID = $this->surveyID;
        $date = now()->format('Y-m-d H:i:s');

        // Sanitasi nama survey dan tanggal untuk menghilangkan karakter yang tidak valid
        $surveyName = str_replace(['/', '\\'], '-', $surveyName);
        $date = str_replace(['/', '\\', ':'], '-', $date);

        return Excel::download(new AnswersExport($surveyID), '[Jawaban] ' . $surveyName . ' ' . $date . '.xlsx');
    }



    // fitur resampling
    public $currentRespondentsPercent;
    public $currentRespondentsCount;
    public $afterRespondentsPercent;
    #[Validate('required|not_in:|numeric|min:0')]
    public $resamplingData;
    public $fullyData;

    public function updatedResamplingData()
    {
        $this->validate([
            'resamplingData' => 'required|numeric|min:0',
        ]);
        $this->afterRespondentsPercent = ($this->currentRespondentsCount + $this->resamplingData) / $this->expectedRespondents * 100;
    }

    public function generateResampling()
    {
        $this->validate([
            'resamplingData' => 'required|numeric|min:0',
        ]);

        $survey = Survey::find($this->surveyID);


        $this->alert('success', 'Sukses!', [
            'position' => 'center',
            'timer' => 2000,
            'toast' => true,
            'text' => 'Resampling berhasil dilakukan.',
        ]);
    }


    #[Layout('layouts.app')]
    public function render()
    {
        // $surveyID = $this->surveyID;

        $survey = Survey::find($this->surveyID);
        $roleIds = json_decode($survey->role_id, true);

        $targetRespondens = TargetResponden::whereIn('role_id', $roleIds)
            ->leftJoin('entries', function ($join) {
                $join->on('target_respondens.id', '=', 'entries.target_responden_id')
                    ->where('entries.survey_id', '=', $this->surveyID);
            })
            ->where('name', 'like', "%{$this->search}%")
            ->select(
                'target_respondens.*',
                DB::raw('CASE WHEN entries.target_responden_id IS NOT NULL THEN true ELSE false END as submitted')
            )
            ->orderBy('name')->paginate(20);

        // $targetRespondens = DB::table('target_respondens')
        //     ->leftJoin('entries', function ($join) {
        //         $join->on('target_respondens.id', '=', 'entries.target_responden_id')
        //             ->where('entries.survey_id', '=', $this->surveyID);
        //     })
        //     // ->where('target_respondens.type', '=', 'individual')
        //     ->where('name', 'like', "%{$this->search}%")
        //     ->select(
        //         'target_respondens.*',
        //         DB::raw('CASE WHEN entries.target_responden_id IS NOT NULL THEN true ELSE false END as submitted')
        //     )
        //     ->orderBy('name')
        //     ->paginate(10);
        return view('livewire.survey.monitoring', [
            'surveyID' => $this->surveyID,
            'targetRespondens' => $targetRespondens,
            'lastUpdatedTime' => $this->lastUpdatedTime,
            'expectedRespondents' => $this->expectedRespondents,
            'survey' => Survey::find($this->surveyID),
        ]);
    }
}
