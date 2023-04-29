import Input from '@/Components/Crud/Input';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useState } from 'react'

export default function Add({ errors, shift }) {

    const [values, setValues] = useState({
        kode_shift: shift.kode_shift,
        nama: shift.nama,
        jam_buka_datang: shift.jam_buka_datang,
        jam_tepat_datang: shift.jam_tepat_datang,
        jam_tutup_datang: shift.jam_tutup_datang,
        toleransi_datang: shift.toleransi_datang,
        jam_buka_istirahat: shift.jam_buka_istirahat,
        jam_tepat_istirahat: shift.jam_tepat_istirahat,
        jam_tutup_istirahat: shift.jam_tutup_istirahat,
        toleransi_istirahat: shift.toleransi_istirahat,
        jam_buka_pulang: shift.jam_buka_pulang,
        jam_tepat_pulang: shift.jam_tepat_pulang,
        jam_tutup_pulang: shift.jam_tutup_pulang,
        toleransi_pulang: shift.toleransi_pulang,
        id: shift.id,
    })

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('master.shift.store'), values);
    }

    return (
        <div>
             <div className="toolbar mb-5 mb-lg-7 d-flex justify-content-between">
                <div className="page-title d-flex flex-column me-3">
                    <h1 className="d-flex text-dark fw-bolder my-1 fs-3">Master</h1>
                    <ul className="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                        <li className="breadcrumb-item text-gray-600">
                            <a href="/" className="text-gray-600 text-hover-primary">Home</a>
                        </li>
                        <li className="breadcrumb-item text-gray-600">shift</li>
                        <li className="breadcrumb-item text-gray-500">Data</li>
                    </ul>
                </div>
                <div className="d-flex align-items-center py-2 py-md-1" >
                    <Link href={route('master.shift.index')} className="btn btn-dark"><b>Kembali</b></Link>
                </div>
            </div>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Tambah shift</span>
                    </h3>
                </div>
                <div className="card-body py-3">
                    <form onSubmit={submit}>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Kode shift</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="kode_shift" disabled={values.id != undefined ? true : false} type="number" onChange={updateData} value={values.kode_shift} className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.kode_shift && <div className="text-danger">{errors.kode_shift}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Nama shift</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="nama" type="text" onChange={updateData} value={values.nama} className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.nama && <div className="text-danger">{errors.nama}</div>}
                        </div>
                        <Input name="jam_buka_datang" type='time' required={true} values={values.jam_buka_datang} onChangeHandle={updateData} />
                        <Input name="jam_tepat_datang" type='time' required={true} values={values.jam_tepat_datang} onChangeHandle={updateData} />
                        <Input name="jam_tutup_datang" type='time' required={true} values={values.jam_tutup_datang} onChangeHandle={updateData} />
                        <Input name="toleransi_datang" type='number' required={false} values={values.toleransi_datang} onChangeHandle={updateData} />
                        <Input name="jam_buka_istirahat" type='time' required={false} values={values.jam_buka_istirahat} onChangeHandle={updateData} />
                        <Input name="jam_tepat_istirahat" type='time' required={false} values={values.jam_tepat_istirahat} onChangeHandle={updateData} />
                        <Input name="jam_tutup_istirahat" type='time' required={false} values={values.jam_tutup_istirahat} onChangeHandle={updateData} />
                        <Input name="toleransi_istirahat" type='number' required={false} values={values.toleransi_istirahat} onChangeHandle={updateData} />
                        <Input name="jam_buka_pulang" type='time' required={true} values={values.jam_buka_pulang} onChangeHandle={updateData} />
                        <Input name="jam_tepat_pulang" type='time' required={true} values={values.jam_tepat_pulang} onChangeHandle={updateData} />
                        <Input name="jam_tutup_pulang" type='time' required={true} values={values.jam_tutup_pulang} onChangeHandle={updateData} />
                        <Input name="toleransi_pulang" type='number' required={false} values={values.toleransi_pulang} onChangeHandle={updateData} />
                        <div className="float-right">
                            <button type="submit" className="btn btn-primary">Simpan</button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    )
}

Add.layout = (page) => <Authenticated children={page} />