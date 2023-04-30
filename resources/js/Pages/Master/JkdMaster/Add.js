import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useState } from 'react'
import { SwatchesPicker } from 'react-color';
import { GithubPicker } from 'react-color';
import { CompactPicker, TwitterPicker } from 'react-color';

export default function Add({ errors, jkdMaster }) {

    const [values, setValues] = useState({
        nama: jkdMaster.nama,
        kode_jkd: jkdMaster.kode_jkd,
        jam_datang: jkdMaster.jam_datang,
        jam_pulang: jkdMaster.jam_pulang,
        istirahat: jkdMaster.istirahat,
        toleransi_datang: jkdMaster.toleransi_datang,
        toleransi_pulang: jkdMaster.toleransi_pulang,
        color: jkdMaster.color,
        id: jkdMaster.id,
    })

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }
    const changeColor = (e) => {
        setValues({...values, color: e.hex })
    }

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('master.jamKerjaDinamis.jkdMaster.store'), values);
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
                        <li className="breadcrumb-item text-gray-600">Jam Kerja Dinamis Master</li>
                        <li className="breadcrumb-item text-gray-500">Data</li>
                    </ul>
                </div>
                <div className="d-flex align-items-center py-2 py-md-1" >
                    <Link href={route('master.jamKerjaDinamis.jkdMaster.index')} className="btn btn-dark"><b>Kembali</b></Link>
                </div>
            </div>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Tambah Data</span>
                    </h3>
                </div>
                <div className="card-body py-3">
                    <form onSubmit={submit}>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Nama</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="nama" type="text" onChange={updateData} value={values.nama} className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.nama && <div className="text-danger">{errors.nama}</div>}
                        </div>
                        <div class="row">
                            <div className="col-lg fv-row fv-plugins-icon-container">
                                <label>Jam Datang</label>
                                <input name="jam_datang" value={values.jam_datang} type="time" onChange={updateData} className="form-control form-control-lg form-control-solid" />
                            </div>
                            <div className="col-lg fv-row fv-plugins-icon-container">
                                <label>Jam Pulang</label>
                                <input name="jam_pulang" type="time" onChange={updateData} value={values.jam_pulang} className="form-control form-control-lg form-control-solid" />
                            </div>
                            <div className="col-lg fv-row fv-plugins-icon-container">
                                <label>Istirahat (Menit)</label>
                                <input name="istirahat" type="number" onChange={updateData} value={values.istirahat} className="form-control form-control-lg form-control-solid" />
                            </div>
                            <div className="col-lg fv-row fv-plugins-icon-container">
                                <label>Toleransi Datang (Menit)</label>
                                <input name="toleransi_datang" type="number" onChange={updateData} value={values.toleransi_datang} className="form-control form-control-lg form-control-solid" />
                            </div>
                            <div className="col-lg fv-row fv-plugins-icon-container">
                                <label>Toleransi Pulang (Menit)</label>
                                <input name="toleransi_pulang" type="number" onChange={updateData} value={values.toleransi_pulang} className="form-control form-control-lg form-control-solid" />
                            </div>
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-12 col-form-label required fw-bold fs-6">Warna</label>
                            <div className="col-lg-12 fv-row fv-plugins-icon-container">
                                <SwatchesPicker height="180px" width='100%'  onChange={changeColor} color={values.color} />
                            </div>
                            {errors.color && <div className="text-danger">{errors.color}</div>}
                        </div>
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