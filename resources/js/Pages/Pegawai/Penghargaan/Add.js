import Input from '@/Components/Crud/Input';
import Penghargaan from '@/Components/Select/Penghargaan';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useState } from 'react'
import Detail from '../Pegawai/Detail';

export default function Add({ errors, pegawai, Rpenghargaan }) {

    const [values, setValues] = useState({
        kode_penghargaan: Rpenghargaan.kode_penghargaan,
        oleh: Rpenghargaan.oleh,
        nomor_sk: Rpenghargaan.nomor_sk,
        tanggal_sk: Rpenghargaan.tanggal_sk,
        file: Rpenghargaan.file,
        id: Rpenghargaan.id,
    });

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    const changeSelect = (e, name) => {
        setValues({ ...values, [name]: e[name] })
    }

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('pegawai.penghargaan.store', pegawai.nip), values);
    }

    return (
        <Detail pegawai={pegawai}>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Tambah Riwayat penghargaan</span>
                    </h3>
                    <div class="card-toolbar">
                        <Link preserveScroll href={route('pegawai.penghargaan.index', pegawai.nip)} class="btn btn-dark fw-bolder me-auto px-4 py-3">Kembali</Link>
                    </div>
                </div>
                <div className="card-body py-3">
                    <form onSubmit={submit}>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Nama Penghargaan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <Penghargaan valueHandle={values.kode_penghargaan} onchangeHandle={(e) => changeSelect(e, 'kode_penghargaan')} />
                            </div>
                            {errors.kode_penghargaan && <div className="text-danger">{errors.kode_penghargaan}</div>}
                        </div>
                        <Input name="oleh" required={true} values={values.oleh} onChangeHandle={updateData} />
                        <Input name="nomor_sk" type='text' required={true} values={values.nomor_sk} onChangeHandle={updateData} />
                        <Input name="tanggal_sk" type='date' required={false} values={values.tanggal_sk} onChangeHandle={updateData} />
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