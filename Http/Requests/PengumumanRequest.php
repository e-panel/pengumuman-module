<?php

namespace Modules\Pengumuman\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengumumanRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'judul' => 'required',
            'perihal' => 'required',
            'lampiran' => 'mimes:png,jpg,jpeg,pdf,doc,docx,xls,xlsx,ppt,pptx'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
