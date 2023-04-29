import Tunjangan from '@/Components/Select/Tunjangan';
import TunjanganMulti from '@/Components/Select/TunjanganMulti';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useEffect, useState } from 'react'

export default function Add({ errors, absensi }) {

    const [tunjangan, setTunjangan] = useState(absensi.kode_tunjangan ?? [])
    const [values, setValues] = useState({
        kode_tunjangan: tunjangan,
        pengali: absensi.pengali,
        keterangan: absensi.keterangan,
        menit: absensi.menit,
        id: absensi.id,
    })

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    const changeSelect = (e) => {
        setTunjangan(e)
    }
    useEffect(() => {
        setValues({...values, kode_tunjangan : tunjangan })
    }, [tunjangan])

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('master.payroll.absensi.update'), values);
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
                        <li className="breadcrumb-item text-gray-600">Payroll</li>
                        <li className="breadcrumb-item text-gray-500">Absensi</li>
                    </ul>
                </div>
                <div className="d-flex align-items-center py-2 py-md-1" >
                    <Link href={route('master.payroll.absensi.index')} className="btn btn-dark"><b>Kembali</b></Link>
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
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Menit Mulai</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input disabled={true} type="text"  value={
                                    values.keterangan == '1' ? `Telat ${values.menit} Menit` :  `Pulang Cepat ${values.menit} Menit`
                                } className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.menit && <div className="text-danger">{errors.menit}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Pengali (Persen)</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="pengali" type="text" onChange={updateData} value={values.pengali} placeholder="Contoh : 1.5" className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.pengali && <div className="text-danger">{errors.pengali}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Sumber Potongan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <TunjanganMulti valueHandle={tunjangan} onchangeHandle={(e) => changeSelect(e)} />
                            </div>
                            {errors.nilai && <div className="text-danger">{errors.nilai}</div>}
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