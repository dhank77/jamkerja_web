import Input from '@/Components/Crud/Input';
import JenisBahasa from '@/Components/Select/JenisBahasa';
import PenguasaanBahasa from '@/Components/Select/PenguasaanBahasa';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useState } from 'react'
import Detail from '../Pegawai/Detail';

export default function Add({ errors, pegawai, Rbahasa }) {

    const [values, setValues] = useState({
        penguasaan: Rbahasa.penguasaan,
        jenis: Rbahasa.jenis,
        nama_bahasa: Rbahasa.nama_bahasa,
        file: Rbahasa.file,
        id: Rbahasa.id,
    });

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    const changeSelect = (e, name) => {
        setValues({ ...values, [name]: e[name] })
    }

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('pegawai.bahasa.store', pegawai.nip), values);
    }

    return (
        <Detail pegawai={pegawai}>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Tambah Riwayat bahasa</span>
                    </h3>
                    <div class="card-toolbar">
                        <Link preserveScroll href={route('pegawai.bahasa.index', pegawai.nip)} class="btn btn-dark fw-bolder me-auto px-4 py-3">Kembali</Link>
                    </div>
                </div>
                <div className="card-body py-3">
                    <form onSubmit={submit}>
                        <Input name="nama_bahasa" required={true} values={values.nama_bahasa} onChangeHandle={updateData} />
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Jenis bahasa</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <JenisBahasa valueHandle={values.jenis} onchangeHandle={(e) => changeSelect(e, 'jenis')} />
                            </div>
                            {errors.jenis && <div className="text-danger">{errors.jenis}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Penguasaan bahasa</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <PenguasaanBahasa valueHandle={values.penguasaan} onchangeHandle={(e) => changeSelect(e, 'penguasaan')} />
                            </div>
                            {errors.penguasaan && <div className="text-danger">{errors.penguasaan}</div>}
                        </div>
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