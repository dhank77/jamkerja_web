import Input from '@/Components/Crud/Input';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useState } from 'react'
import Detail from '../Pegawai/Detail';
import Diklat from '@/Components/Select/Diklat';

export default function Add({ errors, pegawai, Rdiklat }) {

    const [values, setValues] = useState({
        kode_diklat_struktural: Rdiklat.kode_diklat_struktural,
        tempat: Rdiklat.tempat,
        pelaksana: Rdiklat.pelaksana,
        angkatan: Rdiklat.angkatan,
        tanggal_mulai: Rdiklat.tanggal_mulai,
        tanggal_selesai: Rdiklat.tanggal_selesai,
        jumlah_jp: Rdiklat.jumlah_jp,
        no_sertifikat: Rdiklat.no_sertifikat,
        tanggal_sertifikat: Rdiklat.tanggal_sertifikat,
        file: Rdiklat.file,
        id: Rdiklat.id,
    });

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    const changeSelect = (e, name) => {
        setValues({ ...values, [name]: e[name] })
    }

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('pegawai.diklat.store', pegawai.nip), values);
    }

    return (
        <Detail pegawai={pegawai}>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Tambah Riwayat Diklat</span>
                    </h3>
                    <div class="card-toolbar">
                        <Link preserveScroll href={route('pegawai.diklat.index', pegawai.nip)} class="btn btn-dark fw-bolder me-auto px-4 py-3">Kembali</Link>
                    </div>
                </div>
                <div className="card-body py-3">
                    <form onSubmit={submit}>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Nama Diklat</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <Diklat valueHandle={values.kode_diklat_struktural} onchangeHandle={(e) => changeSelect(e, 'kode_diklat_struktural')} />
                            </div>
                            {errors.kode_diklat_struktural && <div className="text-danger">{errors.kode_diklat_struktural}</div>}
                        </div>
                        <Input name="tempat" required={true} values={values.tempat} onChangeHandle={updateData} />
                        <Input name="pelaksana" required={true} values={values.pelaksana} onChangeHandle={updateData} />
                        <Input name="angkatan" type='number' required={true} values={values.angkatan} onChangeHandle={updateData} />
                        <Input name="tanggal_mulai" type='date' required={false} values={values.tanggal_mulai} onChangeHandle={updateData} />
                        <Input name="tanggal_selesai" type='date' required={false} values={values.tanggal_selesai} onChangeHandle={updateData} />
                        <Input name="jumlah_jp" type='number' required={false} values={values.jumlah_jp} onChangeHandle={updateData} />
                        <Input name="no_sertifikat" type='text' required={false} values={values.no_sertifikat} onChangeHandle={updateData} />
                        <Input name="tanggal_sertifikat" type='date' required={false} values={values.tanggal_sertifikat} onChangeHandle={updateData} />
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