import Input from '@/Components/Crud/Input';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useState } from 'react'
import Select from 'react-select';

export default function Add({ errors, tugas, kepala_divisi }) {

    const [values, setValues] = useState({
        nip: tugas.nip,
        tanggal_mulai: tugas.tanggal_mulai,
        tanggal_selesai: tugas.tanggal_selesai,
        deskripsi: tugas.keterangan,
        id: tugas.id,
    });

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('pengajuan.tugas.update'), values);
    }

    return (
        <div className="card mb-5 mb-xl-8">
            <div className="card-header border-0 pt-5 flex">
                <h3 className="card-title align-items-start flex-column">
                    <span className="card-label fw-bolder fs-3 mb-1">Pemberian Tugas</span>
                </h3>
                <div class="card-toolbar">
                    <Link href={route('pengajuan.tugas.index')} class="btn btn-dark fw-bolder me-auto px-4 py-3">Kembali</Link>
                </div>
            </div>
            <div className="card-body py-3">
                <form onSubmit={submit}>
                    <div className="row mb-6">
                        <label className="col-lg-3 col-form-label fw-bold fs-6 required">Tujuan</label>
                        <div className="col-lg-9 fv-row fv-plugins-icon-container">
                            <Select onChange={(e) => setValues({ ...values, nip: e.value })} options={kepala_divisi} name="kepala_divisi" />
                        </div>
                    </div>
                    <Input name="tanggal_mulai" type='date' required={true} values={values.tanggal_mulai} onChangeHandle={updateData} />
                    <Input name="tanggal_selesai" type='date' required={true} values={values.tanggal_selesai} onChangeHandle={updateData} />
                    <div className="row mb-6">
                        <label className="col-lg-3 col-form-label fw-bold fs-6 required">Deskripsi</label>
                        <div className="col-lg-9 fv-row fv-plugins-icon-container">
                            <textarea onChange={updateData} name="deskripsi" id="deskripsi" cols="30" rows="4" value={values.deskripsi} className="form-control" />
                        </div>
                        {errors.deskripsi && <div className="text-danger">{errors.deskripsi}</div>}
                    </div>
                    <div className="float-right">
                        <button type="submit" className="btn btn-primary">Simpan</button>
                    </div>

                </form>

            </div>
        </div>
    )
}

Add.layout = (page) => <Authenticated children={page} />
