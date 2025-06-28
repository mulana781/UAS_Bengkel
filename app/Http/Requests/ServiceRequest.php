<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'vehicle_id' => 'required|exists:vehicles,id',
            'date' => 'required|date',
            'kilometer' => 'required|numeric|min:0',
            'description' => 'required|string|max:1000',
            'status' => 'required|in:pending,in_progress,completed'
        ];
    }

    public function messages()
    {
        return [
            'vehicle_id.required' => 'Kendaraan harus dipilih',
            'vehicle_id.exists' => 'Kendaraan tidak valid',
            'date.required' => 'Tanggal service harus diisi',
            'date.date' => 'Format tanggal tidak valid',
            'kilometer.required' => 'Kilometer harus diisi',
            'kilometer.numeric' => 'Kilometer harus berupa angka',
            'kilometer.min' => 'Kilometer tidak boleh negatif',
            'description.required' => 'Deskripsi service harus diisi',
            'description.max' => 'Deskripsi maksimal 1000 karakter',
            'status.required' => 'Status service harus dipilih',
            'status.in' => 'Status service tidak valid'
        ];
    }
} 