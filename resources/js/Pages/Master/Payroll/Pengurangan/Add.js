import Eselon from '@/Components/Select/Eselon';
import Satuan from '@/Components/Select/Satuan';
import TunjanganMultiAll from '@/Components/Select/TunjanganMultiAll';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useEffect, useState } from 'react'
import NumberFormat from 'react-number-format';

export default function Add({ errors, pengurangan }) {

    const [kode, setKode] = useState(pengurangan.kode_persen ?? [])
    const [values, setValues] = useState({
        kode_kurang: pengurangan.kode_kurang,
        nama: pengurangan.nama,
        satuan: pengurangan.satuan,
        nilai: pengurangan.nilai,
        kode_persen: kode,
        id: pengurangan.id,
    })

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    const changeSelect = (e, name) => {
        setValues({ ...values, [name]: e[name] })
    }
    const changeKodePersen = (e) => {
        setKode(e)
    }

    useEffect(() => {
        setValues({...values, kode_persen : kode})
    }, [kode])
    

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('master.payroll.pengurangan.store'), values);
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
                        <li className="breadcrumb-item text-gray-600">Komponen Pengurangan</li>
                        <li className="breadcrumb-item text-gray-500">Data</li>
                    </ul>
                </div>
                <div className="d-flex align-items-center py-2 py-md-1" >
                    <Link href={route('master.payroll.pengurangan.index')} className="btn btn-dark"><b>Kembali</b></Link>
                </div>
            </div>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Tambah Komponen</span>
                    </h3>
                </div>
                <div className="card-body py-3">
                    <form onSubmit={submit}>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Kode</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="kode_kurang" disabled={values.id != undefined ? true : false} type="number" onChange={updateData} value={values.kode_kurang} className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.kode_kurang && <div className="text-danger">{errors.kode_kurang}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Nama Komponen</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="nama" type="text" onChange={updateData} value={values.nama} className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.nama && <div className="text-danger">{errors.nama}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Satuan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <Satuan valueHandle={values.satuan} onchangeHandle={(e) => changeSelect(e, 'satuan')} />
                            </div>
                            {errors.satuan && <div className="text-danger">{errors.satuan}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Nilai</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <NumberFormat className="form-control" name="nilai" onChange={updateData} value={values.nilai} thousandSeparator={'.'} decimalSeparator={','} />
                            </div>
                            {errors.nilai && <div className="text-danger">{errors.nilai}</div>}
                        </div>
                        {
                            values.satuan == 2 &&
                            <div className="row mb-6">
                                <label className="col-lg-3 col-form-label required fw-bold fs-6">Persentase Dari</label>
                                <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                    <TunjanganMultiAll valueHandle={kode} onchangeHandle={(e) => changeKodePersen(e)} />
                                </div>
                                {errors.kode_persen && <div className="text-danger">{errors.kode_persen}</div>}
                            </div>
                        }
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