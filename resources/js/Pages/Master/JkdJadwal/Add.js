import JkdMaster from '@/Components/Select/JkdMaster';
import Pegawai from '@/Components/Select/Pegawai';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useState } from 'react'

export default function Add({ errors, jkdJadwal }) {

    const [values, setValues] = useState({
        kode_jkd: jkdJadwal.kode_jkd,
        nip: jkdJadwal.nip,
        tanggal: jkdJadwal.tanggal,
        id: jkdJadwal.id,
    })

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    const changeSelect = (e, name) => {
        setValues({ ...values, [name]: e.value })
    }

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('master.jamKerjaDinamis.jkdJadwal.store'), values);
    }

    return (
        <div>
            <div className="toolbar mb-5 mb-lg-7">
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
                    <Link href={route('master.jamKerjaDinamis.jkdJadwal.index')} className="btn btn-dark"><b>Kembali</b></Link>
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
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Jam Kerja</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <JkdMaster valueHandle={values.kode_jkd} onchangeHandle={(e) => changeSelect(e, 'kode_jkd')} />
                            </div>
                            {errors.kode_jkd && <div className="text-danger">{errors.kode_jkd}</div>}
                        </div>
                        {
                            jkdJadwal.id == undefined &&
                            <div className="row mb-6">
                                <label className="col-lg-3 col-form-label required fw-bold fs-6">Nama Pegawai</label>
                                <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                    <Pegawai isMulti={false} valueHandle={values.nip} onchangeHandle={(e) => changeSelect(e, 'nip')}  />
                                </div>
                                {errors.nip && <div className="text-danger">{errors.nip}</div>}
                            </div>
                        }
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Tanggal</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="tanggal" type="date" onChange={updateData} value={values.tanggal} className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.tanggal && <div className="text-danger">{errors.tanggal}</div>}
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