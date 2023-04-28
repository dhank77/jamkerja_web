import Input from '@/Components/Crud/Input';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useState } from 'react'

export default function Approved({ errors, cuti }) {

    const [values, setValues] = useState({
        nomor_surat: cuti.nomor_surat,
        tanggal_surat: cuti.tanggal_surat,
        komentar: cuti.komentar,
        file: cuti.file,
        id: cuti.id,
    });

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('pengajuan.cuti.update'), values);
    }

    return (
        <div className="card mb-5 mb-xl-8">
            <div className="card-header border-0 pt-5 flex">
                <h3 className="card-title align-items-start flex-column">
                    <span className="card-label fw-bolder fs-3 mb-1">Form Terima Pengajuan Cuti</span>
                </h3>
                <div class="card-toolbar">
                    <Link href={route('pengajuan.cuti.index')} class="btn btn-dark fw-bolder me-auto px-4 py-3">Kembali</Link>
                </div>
            </div>
            <div className="card-body py-3">
                <form onSubmit={submit}>
                    <Input name="nomor_surat" required={true} values={values.nomor_surat} onChangeHandle={updateData} />
                    <Input name="tanggal_surat" type='date' required={true} values={values.tanggal_surat} onChangeHandle={updateData} />
                    <div className="row mb-6">
                        <label className="col-lg-3 col-form-label fw-bold fs-6">Komentar</label>
                        <div className="col-lg-9 fv-row fv-plugins-icon-container">
                            <textarea onChange={updateData} name="komentar" id="komentar" cols="30" rows="4" value={values.komentar} className="form-control" />
                        </div>
                        {errors.komentar && <div className="text-danger">{errors.komentar}</div>}
                    </div>
                    <div className="row mb-6">
                        <label className="col-lg-3 col-form-label fw-bold fs-6">Unggah Surat Persetujuan</label>
                        <div className="col-lg-9 fv-row fv-plugins-icon-container">
                            {
                                values.file == undefined || values.file == '' ? ''
                                    : <a href={typeof (values.file) == 'object' ? URL.createObjectURL(values.file) : "/storage/" + values.file} className="badge badge-success mb-1 hover:text-gray-200 cursor-pointer" target="_blank">File Saat Ini</a>
                            }
                            <input type="file" accept="application/pdf, image/png, image/jpeg, image/jpg" name="file" className="form-control p-3 border border-gray-200 rounded" onChange={e => setValues({ ...values, file: e.target.files[0] })} />

                        </div>
                        {errors.file && <div className="text-danger">{errors.file}</div>}
                    </div>

                    <div className="float-right">
                        <button type="submit" className="btn btn-primary">Simpan</button>
                    </div>

                </form>

            </div>
        </div>
    )
}

Approved.layout = (page) => <Authenticated children={page} />
