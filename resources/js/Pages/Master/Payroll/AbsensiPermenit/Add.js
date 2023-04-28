import Eselon from '@/Components/Select/Eselon';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useState } from 'react'
import NumberFormat from 'react-number-format';

export default function Add({ errors, absensiPermenit }) {

    const [values, setValues] = useState({
        kode_eselon: absensiPermenit.kode_eselon,
        keterangan: absensiPermenit.keterangan,
        potongan: absensiPermenit.potongan,
        id: absensiPermenit.id,
    })

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    const changeSelect = (e, name) => {
        setValues({ ...values, [name]: e[name] })
    }

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('master.payroll.absensiPermenit.update'), values);
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
                        <li className="breadcrumb-item text-gray-600">Payroll</li>
                        <li className="breadcrumb-item text-gray-500">Absensi Permenit</li>
                    </ul>
                </div>
                <div className="d-flex align-items-center py-2 py-md-1" >
                    <Link href={route('master.payroll.absensiPermenit.index')} className="btn btn-dark"><b>Kembali</b></Link>
                </div>
            </div>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Tambah Absensi</span>
                    </h3>
                </div>
                <div className="card-body py-3">
                    <form onSubmit={submit}>
                    <div className="row mb-6">
                            <label className="col-lg-3 col-form-label fw-bold fs-6">Level Jabatan
                            </label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <Eselon valueHandle={values.kode_eselon} onchangeHandle={(e) => changeSelect(e, 'kode_eselon')} />
                                <div className='text-danger'>* Kosongkan untuk semua level jabatan</div>
                            </div>
                            {errors.kode_eselon && <div className="text-danger">{errors.kode_eselon}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Potongan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <NumberFormat className="form-control" name="potongan" onChange={updateData} value={values.potongan} thousandSeparator={'.'} decimalSeparator={','} />
                            </div>
                            {errors.potongan && <div className="text-danger">{errors.potongan}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Keterangan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <select name="keterangan" id="keterangan" className='form-control' onChange={updateData} value={values.keterangan}>
                                    <option value="">Pilih</option>
                                    <option value="permenit">Potongan Permenit</option>
                                    <option value="perceklok">Potongan Perceklok</option>
                                </select>
                            </div>
                            {errors.keterangan && <div className="text-danger">{errors.keterangan}</div>}
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