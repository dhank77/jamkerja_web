import Input from '@/Components/Crud/Input';
import Lainnya from '@/Components/Select/Lainnya';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useState } from 'react'
import Detail from '../Pegawai/Detail';

export default function Add({ errors, pegawai, Rlainnya }) {

    const [values, setValues] = useState({
        kode_lainnya: Rlainnya.kode_lainnya,
        tanggal_sk: Rlainnya.tanggal_sk,
        nomor_sk: Rlainnya.nomor_sk,
        file: Rlainnya.file,
        id: Rlainnya.id,
    });

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    const changeSelect = (e, name) => {
        setValues({ ...values, [name]: e[name] })
    }


    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('pegawai.lainnya.store', pegawai.nip), values);
    }

    return (
        <Detail pegawai={pegawai}>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Tambah Riwayat lainnya</span>
                    </h3>
                    <div class="card-toolbar">
                        <Link preserveScroll href={route('pegawai.lainnya.index', pegawai.nip)} class="btn btn-dark fw-bolder me-auto px-4 py-3">Kembali</Link>
                    </div>
                </div>
                <div className="card-body py-3">
                    <form onSubmit={submit}>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Jenis</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <Lainnya valueHandle={values.kode_lainnya} onchangeHandle={(e) => changeSelect(e, 'kode_lainnya')} />
                            </div>
                            {errors.kode_lainnya && <div className="text-danger">{errors.kode_lainnya}</div>}
                        </div>
                        <Input name="nomor_sk" type='text' required={true} values={values.nomor_sk} onChangeHandle={updateData} />
                        <Input name="tanggal_sk" type='date' required={true} values={values.tanggal_sk} onChangeHandle={updateData} />
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