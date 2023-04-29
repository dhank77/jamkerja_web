import Month from '@/Components/Date/Month';
import Year from '@/Components/Date/Year';
import Eselon from '@/Components/Select/Eselon';
import IsPeriode from '@/Components/Select/IsPeriode';
import KeteranganPayroll from '@/Components/Select/KeteranganPayroll';
import PayrollKurang from '@/Components/Select/PayrollKurang';
import Pegawai from '@/Components/Select/Pegawai';
import Skpd from '@/Components/Select/Skpd';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useEffect, useState } from 'react'
import { Cascader } from 'rsuite';

export default function Add({ errors, kurang, parent }) {

    const [keterangan, setketerangan] = useState(kurang.kode_keterangan ?? [])
    const [values, setValues] = useState({
        kode_kurang: kurang.kode_kurang,
        bulan: kurang.bulan,
        tahun: kurang.tahun,
        keterangan: kurang.keterangan,
        is_periode: kurang.is_periode,
        kode_keterangan: keterangan,
        id: kurang.id,
    })

    const changeKeterangan = (e) => {
        setketerangan(e)
    }

    const changeSelect = (e, name) => {
        setValues({ ...values, [name]: e[name] })
    }
    const changeValue = (e, name) => {
        setValues({ ...values, [name]: e.value })
    }

    useEffect(() => {
        setketerangan([])
    }, [values.keterangan])

    useEffect(() => {
        setValues({...values, kode_keterangan : keterangan})
    }, [keterangan])

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('payroll.kurang.store'), values);
    }

    return (
        <div>
            <div className="toolbar mb-5 mb-lg-7 d-flex justify-content-between">
                <div className="page-title d-flex flex-column me-3">
                    <h1 className="d-flex text-dark fw-bolder my-1 fs-3">Payroll</h1>
                    <ul className="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                        <li className="breadcrumb-item text-gray-600">
                            <a href="/" className="text-gray-600 text-hover-primary">Home</a>
                        </li>
                        <li className="breadcrumb-item text-gray-600">Pengurangan</li>
                        <li className="breadcrumb-item text-gray-500">Tambah Data</li>
                    </ul>
                </div>
                <div className="d-flex align-items-center py-2 py-md-1" >
                    <Link href={route('payroll.kurang.index')} className="btn btn-dark"><b>Kembali</b></Link>
                </div>
            </div>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Data Pengurangan Payroll</span>
                    </h3>
                </div>
                <div className="card-body py-3">
                    <form onSubmit={submit}>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Komponen</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <PayrollKurang valueHandle={values.kode_kurang} onchangeHandle={(e) => changeSelect(e, 'kode_kurang')} />
                            </div>
                            {errors.kode_kurang && <div className="text-danger">{errors.kode_kurang}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Periode</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <IsPeriode valueHandle={values.is_periode} onchangeHandle={(e) => changeSelect(e, 'is_periode')} />
                            </div>
                            {errors.is_periode && <div className="text-danger">{errors.is_periode}</div>}
                        </div>
                        {
                            values.is_periode == 1 &&
                            <>
                                <div className="row mb-6">
                                    <label className="col-lg-3 col-form-label required fw-bold fs-6">Bulan</label>
                                    <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                        <Month value={values.bulan} filterBulan={(e) => changeValue(e, 'bulan')} />
                                    </div>
                                    {errors.bulan && <div className="text-danger">{errors.bulan}</div>}
                                </div>
                                <div className="row mb-6">
                                    <label className="col-lg-3 col-form-label required fw-bold fs-6">Tahun</label>
                                    <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                        <Year value={values.tahun} filterTahun={(e) => changeValue(e, 'tahun')} />
                                    </div>
                                    {errors.tahun && <div className="text-danger">{errors.tahun}</div>}
                                </div>
                            </>
                        }
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Untuk</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <KeteranganPayroll valueHandle={values.keterangan} onchangeHandle={(e) => changeSelect(e, 'keterangan')} />
                            </div>
                            {errors.keterangan && <div className="text-danger">{errors.keterangan}</div>}
                        </div>
                        {
                            values.keterangan == '1' &&
                            <div className="row mb-6">
                                <label className="col-lg-3 col-form-label required fw-bold fs-6">Pilih Pegawai Tertentu</label>
                                <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                    <Pegawai valueHandle={keterangan} onchangeHandle={(e) => changeKeterangan(e)} />
                                </div>
                                {errors.kode_keterangan && <div className="text-danger">{errors.kode_keterangan}</div>}
                            </div>
                        }
                        {
                            values.keterangan == '2' &&
                            <div className="row mb-6">
                                <label className="col-lg-3 col-form-label required fw-bold fs-6">Pilih Jabatan</label>
                                <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <Cascader className="-z-10" data={parent} value={keterangan.toString()} onChange={changeKeterangan} parentSelectable style={{ width: '100%' }} />
                                </div>
                                {errors.kode_keterangan && <div className="text-danger">{errors.kode_keterangan}</div>}
                            </div>
                        }
                        {
                            values.keterangan == '3' &&
                            <div className="row mb-6">
                                <label className="col-lg-3 col-form-label required fw-bold fs-6">Pilih Berdasarkan Level Jabatan</label>
                                <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                    <Eselon valueHandle={keterangan?.kode_eselon} onchangeHandle={(e) => changeKeterangan(e)} />
                                </div>
                                {errors.kode_keterangan && <div className="text-danger">{errors.kode_keterangan}</div>}
                            </div>
                        }
                        {
                            values.keterangan == '4' &&
                            <div className="row mb-6">
                                <label className="col-lg-3 col-form-label required fw-bold fs-6">Pilih Berdasarkan Divisi</label>
                                <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                    <Skpd valueHandle={keterangan?.kode_skpd} onchangeHandle={(e) => changeKeterangan(e)} />
                                </div>
                                {errors.kode_keterangan && <div className="text-danger">{errors.kode_keterangan}</div>}
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