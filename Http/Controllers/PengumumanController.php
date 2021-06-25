<?php

namespace Modules\Pengumuman\Http\Controllers;

use Modules\Core\Http\Controllers\CoreController as Controller;
use Illuminate\Http\Request;

use Modules\Pengumuman\Entities\Pengumuman;
use Modules\Pengumuman\Http\Requests\PengumumanRequest;

class PengumumanController extends Controller
{
    protected $title;

    /**
     * Siapkan konstruktor controller
     * 
     * @param Pengumuman $data
     * @param Kategori $kategori
     */
    public function __construct(Pengumuman $data) 
    {
        $this->title = __('pengumuman::general.title');
        $this->data = $data;

        $this->toIndex = route('epanel.pengumuman.index');
        $this->prefix = 'epanel.pengumuman';
        $this->view = 'pengumuman::pengumuman';

        $this->tCreate = __('pengumuman::general.created', ['title' => $this->title]);
        $this->tUpdate = __('pengumuman::general.updated', ['title' => $this->title]);
        $this->tDelete = __('pengumuman::general.deleted', ['title' => $this->title]);

        view()->share([
            'title' => $this->title, 
            'view' => $this->view, 
            'prefix' => $this->prefix
        ]);
    }

    /**
     * Tampilkan halaman utama modul yang dipilih
     * 
     * @param Request $request
     * @return Response|View
     */
    public function index(Request $request) 
    {
        $data = $this->data->latest()->get();

        if($request->has('datatable')):
            return $this->datatable($data);
        endif;

        return view("$this->view.index", compact('data'));
    }

    /**
     * Tampilkan halaman untuk menambah data
     * 
     * @return Response|View
     */
    public function create() 
    {
        return view("$this->view.create");
    }

    /**
     * Lakukan penyimpanan data ke database
     * 
     * @param Request $request
     * @return Response|View
     */
    public function store(PengumumanRequest $request) 
    {
        $input = $request->all();
        
        $input['id_operator'] = optional(auth()->user())->id;
        if($request->hasFile('lampiran')):
            $input['lampiran'] = $this->upload($request->file('lampiran'), str_slug($request->judul));
        endif;

        $this->data->create($input);

        notify()->flash($this->tCreate, 'success');
        return redirect($this->toIndex);
    }

    /**
     * Menampilkan detail lengkap
     * 
     * @param Int $id
     * @return Response|View
     */
    public function show($id)
    {
        return abort(404);
    }

    /**
     * Tampilkan halaman perubahan data
     * 
     * @param Int $id
     * @return Response|View
     */
    public function edit($id)
    {
        $edit = $this->data->uuid($id)->firstOrFail();
    
        return view("$this->view.edit", compact('edit'));
    }

    /**
     * Lakukan perubahan data sesuai dengan data yang diedit
     * 
     * @param Request $request
     * @param Int $id
     * @return Response|View
     */
    public function update(PengumumanRequest $request, $id)
    {    
        $edit = $this->data->uuid($id)->firstOrFail();

        $input = $request->all();
    
        if($request->hasFile('lampiran')):
            if(!is_null($edit->lampiran)):
                deleteFile($edit->lampiran);
            endif;
            $input['lampiran'] = $this->upload($request->file('lampiran'), str_slug($request->judul));
        else:
            $input['lampiran'] = $edit->lampiran;
        endif;
        
        $edit->update($input);

        notify()->flash($this->tUpdate, 'success');
        return redirect($this->toIndex);
    }

    /**
     * Lakukan penghapusan data yang tidak diinginkan
     * 
     * @param Request $request
     * @param Int $id
     * @return Response|String
     */
    public function destroy(Request $request, $id)
    {
        if($request->has('pilihan')):
            foreach($request->pilihan as $temp):
                $each = $this->data->uuid($temp)->firstOrFail();
                if(!is_null($each->lampiran)):
                    \Storage::delete(str_replace('storage/', 'public/', $each->lampiran));
                endif;
                $each->delete();
            endforeach;
            notify()->flash($this->tDelete, 'success');
            return redirect()->back();
        endif;
    }

    /**
     * Function for Upload File
     * 
     * @param  $file, $filename
     * @return URI
     */
    public function upload($file, $filename) 
    {
        $ekstensi = $file->getClientOriginalExtension();
        $tmpFileDate =  date('Y-m') .'/'.date('d').'/';
        
        \Storage::disk()->put('public/Pengumuman/'.$tmpFileDate.$filename.'.'.$ekstensi, fopen($file, 'r+'), 'public');

        return "storage/Pengumuman/{$tmpFileDate}{$filename}.{$ekstensi}";
    }

    /**
     * Datatable API
     * 
     * @param  $data
     * @return Datatable
     */
    public function datatable($data) 
    {
        return datatables()->of($data)
            ->editColumn('pilihan', function($data) {
                $return  = '<span>';
                $return .= '    <div class="checkbox checkbox-only">';
                $return .= '        <input type="checkbox" id="pilihan['.$data->id.']" name="pilihan[]" value="'.$data->uuid.'">';
                $return .= '        <label for="pilihan['.$data->id.']"></label>';
                $return .= '    </div>';
                $return .= '</span>';
                return $return;
            })
            ->editColumn('label', function($data) {
                $return  = $data->judul;
                $return .= '<div class="font-11 color-blue-grey-lighter">';
                $return .= '    <i class="font-icon font-icon-clip"></i> &nbsp; Lampiran : ';
                $return .= \Storage::exists(str_replace('storage/', 'public/', $data->lampiran)) ? 'Ada' : 'Tidak Ada';
                $return .= '</div>';
                return $return;
            })
            ->editColumn('hit', function($data) {
                $return  = '<div class="font-11 color-blue-grey-lighter uppercase">Hit(s)</div>';
                $return .= $data->view . ' Kali';
                return $return;
            })
            ->editColumn('tanggal', function($data) {
                \Carbon\Carbon::setLocale('id');
                $return  = '<small>' . date('Y-m-d h:i:s', strtotime($data->created_at)) . '</small><br/>';
                if($data->created_at):
                    $return .= str_replace('yang ', '', $data->created_at->diffForHumans());
                endif;
                return $return;
            })
            ->editColumn('oleh', function($data) {
                $return  = '<img src="'. \Avatar::create(optional($data->operator)->nama)->toBase64() .'" ';
                $return .= '    data-toggle="tooltip" data-placement="top" data-original-title="Posted by '.optional($data->operator)->nama.'">';
                return $return;
            })
            ->editColumn('aksi', function($data) {
                $return  = '<div class="btn-toolbar">';
                $return .= '    <div class="btn-group btn-group-sm">';
                $return .= '        <a href="'. route("$this->prefix.edit", $data->uuid) .'" role="button" class="btn btn-sm btn-primary-outline">';
                $return .= '            <span class="fa fa-pencil"></span>';
                $return .= '        </a>';
                $return .= '    </div>';
                $return .= '</div>';
                return $return;
            })
            ->rawColumns(['pilihan', 'label', 'hit', 'tanggal', 'oleh', 'aksi'])->toJson();
    }
}
