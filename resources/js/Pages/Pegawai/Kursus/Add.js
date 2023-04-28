import Input from '@/Components/Crud/Input';
import Kursus from '@/Components/Select/Kursus';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useState } from 'react'
import Detail from '../Pegawai/Detail';

export default function Add({ errors, pegawai, Rkursus }) {

    const [values, setValues] = useState({
        kode_kursus: Rkursus.kode_kursus,
        tempat: Rkursus.tempat,
        pelaksana: Rkursus.pelaksana,
        angkatan: Rkursus.angkatan,
        tanggal_mulai: Rkursus.tanggal_mulai,
        tanggal_selesai: Rkursus.tanggal_selesai,
        jumlah_jp: Rkursus.jumlah_jp,
        no_sertifikat: Rkursus.no_sertifikat,
        tanggal_sertifikat: Rkursus.tanggal_sertifikat,
        file: Rkursus.file,
        id: Rkursus.id,
    });

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    const changeSelect = (e, name) => {
        setValues({ ...values, [name]: e[name] })
    }

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('pegawai.kursus.store', pegawai.nip), values);
    }

    return (
        <Detail pegawai={pegawai}>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Tambah Riwayat kursus</span>
                    </h3>
                    <div class="card-toolbar">
                        <Link preserveScroll href={route('pegawai.kursus.index', pegawai.nip)} class="btn btn-dark fw-bolder me-auto px-4 py-3">Kembali</Link>
                    </div>
                </div>
                <div className="card-body py-3">
                    <form onSubmit={submit}>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Nama kursus</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <Kursus valueHandle={values.kode_kursus} onchangeHandle={(e) => changeSelect(e, 'kode_kursus')} />
                            </div>
                            {errors.kode_kursus && <div className="text-danger">{errors.kode_kursus}</div>}
                        </div>
                        <Input name="tempat" required={true} values={values.tempat} onChangeHandle={updateData} />
                        <Input name="pelaksana" required={true} values={values.pelaksana} onChangeHandle={updateData} />
                        <Input name="angkatan" type='number' required={true} values={values.angkatan} onChangeHandle={updateData} />
                        <Input name="tanggal_mulai" type='date' required={false} values={values.tanggal_mulai} onChangeHandle={updateData} />
                        <Input name="tanggal_selesai" type='date' required={false} values={values.tanggal_selesai} onChangeHandle={updateData} />
                        <Input name="jumlah_jp" type='number' required={false} values={values.jumlah_jp} onChangeHandle={updateData} />
                        <Input name="no_sertifikat" type='text' required={true} values={values.no_sertifikat} onChangeHandle={updateData} />
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