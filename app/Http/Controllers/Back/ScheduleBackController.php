<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Web;
use App\Models\Schedule;
use App\Models\ScheduleDay;
use App\Models\ScheduleSubject;
use Storage;
use Alert;
use Str;
use Auth;

class ScheduleBackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['schedule_day'] = ScheduleDay::paginate(6);
        $data['schedule_subject'] = ScheduleSubject::paginate(6);
        $data['web'] = Web::all();
        return view('back.schedule.data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['web'] = Web::all();
        $data['schedule_subject'] = ScheduleSubject::all();
        $data['schedule_day'] = ScheduleDay::all();
        return view('back.schedule.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function schedule_day_store(Request $request)
    {
        
        $data = [
            'hari' => $request->hari,
        ];

        ScheduleDay::create($data)
        ? Alert::success('Berhasil', 'Hari telah berhasil ditambahkan!')
        : Alert::error('Error', 'Hari gagal ditambahkan!');

        return redirect()->back();
    }

    public function schedule_day_update(Request $request, $id)
    {
        $schedule_day = ScheduleDay::findOrFail($id);

        $data = [
            'hari' => $request->edit_hari ? $request->edit_hari : $schedule_day->hari,
           
        ];

        $schedule_day->update($data)
        ? Alert::success('Berhasil', "Hari telah berhasil diubah!")
        : Alert::error('Error', "Hari gagal diubah!");

        return redirect()->back();
    }

    public function schedule_day_destroy($id)
    {
        $schedule = ScheduleDay::findOrFail($id);
        $schedule->delete()
            ? Alert::success('Berhasil', "Hari telah berhasil dihapus.")
            : Alert::error('Error', "Hari gagal dihapus!");

        return redirect()->back();
    }

    public function store(Request $request)
    {
        $request->validate([
            'day_id' => 'required',
            'matkul' => 'required',
            'waktu' => 'required',
        ],
        [
            'day_id.required' => 'Hari harus di isi.',
            'matkul.required' => 'Matkul harus di isi.',
            'waktu.required' => 'Waktu harus di isi.',
        ]);

        $data = [
            'day_id' => $request->day_id,
            'matkul' =>  $request->matkul,
            'waktu' => implode(',', $request->waktu),
        ];

        ScheduleSubject::create($data)
        ? Alert::success('Berhasil', 'Schedule telah berhasil ditambahkan!')
        : Alert::error('Error', 'Schedule gagal ditambahkan!');

        return redirect()->route('schedule-back.index');
    }

    public function checkHari(Request $request) 
    {
        if($request->Input('hari')){
            $hari = ScheduleDay::where('hari',$request->Input('hari'))->first();
            if($hari){
                return 'false';
            }else{
                return  'true';
            }
        }

        if($request->Input('edit_hari')){
            $edit_hari = ScheduleDay::where('hari',$request->Input('edit_hari'))->first();
            if($edit_hari){
                return 'false';
            }else{
                return  'true';
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['schedule_day_origin'] = ScheduleDay::all();
        $data['schedule_subject'] = ScheduleSubject::find($id);
        $data['web'] = Web::all();
        return view('back.schedule.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $schedule_subject = ScheduleSubject::findOrFail($id);
        
        $request->validate([
            'edit_matkul' => 'required',
            'edit_waktu' => 'required',
        ],
        [
            'edit_matkul.required' => 'Matkul harus di isi.',
            'edit_waktu.required' => 'Waktu harus di isi.'
        ]);

        $data = [
            'day_id' => $request->edit_day_id ? $request->edit_day_id : $schedule_subject->day_id,
            'matkul' => $request->edit_matkul ? $request->edit_matkul : $schedule_subject->matkul,
            'waktu' => $request->edit_waktu ? implode(',', $request->edit_waktu) : $schedule_subject->waktu,
        ];

        $schedule_subject->update($data)
        ? Alert::success('Berhasil', "Schedule telah berhasil diubah!")
        : Alert::error('Error', "Schedule gagal diubah!");

        return redirect()->route('schedule-back.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $schedule = ScheduleSubject::findOrFail($id);
        $schedule->days->delete();
        $schedule->delete()
            ? Alert::success('Berhasil', "Schedule telah berhasil dihapus.")
            : Alert::error('Error', "Schedule gagal dihapus!");

        return redirect()->back();
    }
}
