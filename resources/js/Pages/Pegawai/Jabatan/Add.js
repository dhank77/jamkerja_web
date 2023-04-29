import Input from '@/Components/Crud/Input';
import JenisJabatan from '@/Components/Select/JenisJabatan';
import Sebagai from '@/Components/Select/Sebagai';
import Skpd from '@/Components/Select/Skpd';
import Tingkat from '@/Components/Select/Tingkat';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useEffect, useState } from 'react'
import Detail from '../Pegawai/Detail';

export default function Add({ errors, pegawai, Rjabatan }) {

    const [values, setValues] = useState({
        kode_skpd: Rjabatan.kode_skpd,
        kode_tingkat: Rjabatan.kode_tingkat,
        kode_eselon: Rjabatan.kode_eselon,
        jenis_jabatan: Rjabatan.jenis_jabatan,
        no_sk: Rjabatan.no_sk,
        tanggal_sk: Rjabatan.tanggal_sk,
        tanggal_tmt: Rjabatan.tanggal_tmt,
        sebagai: Rjabatan.sebagai,
        file: Rjabatan.file,
        is_akhir: Rjabatan.is_akhir,
        id: Rjabatan.id,
    });

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    const changeSelect = (e, name) => {
        setValues({ ...values, [name]: e[name] })
    }
    const changeCascader = (e, name) => {
        setValues({ ...values, [name]: e })
    }

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('pegawai.jabatan.store', pegawai.nip), values);
    }

    return (
        <Detail pegawai={pegawai}>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Tambah Riwayat Jabatan</span>
                    </h3>
                    <div class="card-toolbar">
                        <Link preserveScroll href={route('pegawai.jabatan.index', pegawai.nip)} class="btn btn-dark fw-bolder me-auto px-4 py-3">Kembali</Link>
                    </div>
                </div>
                <div className="card-body py-3">
                    <form onSubmit={submit}>
                        <div className='row mb-6'>
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Pilihan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container d-flex">
                                <div class="form-check form-check-custom form-check-success form-check-solid form-check-lg ">
                                    <input class="form-check-input" checked={values.is_akhir == 1 ? true : false} onChange={updateData} name='is_akhir' type="radio" value="1" id="flexCheckbox1" />
                                    <label class="form-check-label  mr-10" for="flexCheckbox1">
                                        Jabatan Akhir
                                    </label>
                                </div>
                                <div class="form-check form-check-custom form-check-success form-check-solid form-check-lg">
                                    <input class="form-check-input" checked={values.is_akhir == 0 ? true : false} onChange={updateData} name='is_akhir' type="radio" value="0" id="flexCheckbox2" />
                                    <label class="form-check-label" for="flexCheckbox2">
                                        Riwayat Jabatan
                                    </label>
                                </div>
                            </div>
                            {errors.is_akhir && <div className="text-danger">{errors.is_akhir}</div>}
                        </div>

                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Jenis Jabatan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <JenisJabatan className='z-50' valueHandle={values.jenis_jabatan} onchangeHandle={(e) => changeSelect(e, 'jenis_jabatan')} />
                            </div>
                            {errors.jenis_jabatan && <div className="text-danger">{errors.jenis_jabatan}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Divisi Kerja</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <Skpd className='z-40' onchangeHandle={(e) => changeSelect(e, 'kode_skpd')} valueHandle={values.kode_skpd} />
                            </div>
                            {errors.kode_skpd && <div className="text-danger">{errors.kode_skpd}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Jabatan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <Tingkat skpd={values.kode_skpd} valueHandle={values.kode_tingkat} onchangeHandle={(e) => changeCascader(e, 'kode_tingkat')} />
                            </div>
                            {errors.kode_tingkat && <div className="text-danger">{errors.kode_tingkat}</div>}
                        </div>
                        <Input labels='NO SK' name="no_sk" required={false} values={values.no_sk} onChangeHandle={updateData} />
                        <Input labels='Tanggal SK' name="tanggal_sk" type='date' required={false} values={values.tanggal_sk} onChangeHandle={updateData} />
                        <Input labels='Tanggal Selesai Kontrak' name="tanggal_tmt" type='date' required={false} values={values.tanggal_tmt} onChangeHandle={updateData} />
                        {
                            values.is_akhir == 0 &&
                            <div className="row mb-6">
                                <label className="col-lg-3 col-form-label required fw-bold fs-6">Sebagai</label>
                                <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                    <Sebagai onchangeHandle={(e) => changeSelect(e, 'sebagai')} valueHandle={values.sebagai} />
                                </div>
                                {errors.kode_jabatan && <div className="text-danger">{errors.kode_jabatan}</div>}
                            </div>
                        }
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label fw-bold fs-6">Unggah Dokumen</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                {
                                    values.file == undefined || values.file == '' ? ''
                                        : <a href={typeof (values.file) == 'object' ? URL.createObjectURL(values.file) : "/storage/" + values.file} className="badge badge-success mb-1 hover:text-gray-200 cursor-pointer" target="_blank">File Saat Ini</a>
                                }
                                <input type="file" accept="application/pdf" name="file" className="form-control p-3 border border-gray-200 rounded" onChange={e => setValues({ ...values, file: e.target.files[0] })} />

                            </div>
                            {errors.file && <div className="text-danger">{errors.file}</div>}
                        </div>

                        <div className="float-right">
                            <button type="submit" className="btn btn-primary">Simpan</button>
                        </div>

                    </form>

                </div>
            </div>

        </Detail>
    )
}

Add.layout = (page) => <Authenticated children={page} />