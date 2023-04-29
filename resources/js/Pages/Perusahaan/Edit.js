import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useState } from 'react'

export default function Edit({ errors, perusahaan }) {

    const [update, setUpdate] = useState(perusahaan.id)
    const [values, setValues] = useState({
        nama: perusahaan.nama,
        logo: perusahaan.logo,
        alamat: perusahaan.alamat,
        kontak: perusahaan.kontak,
        direktur: perusahaan.direktur,
        nomor: perusahaan.nomor,
        jumlah_pegawai: perusahaan.jumlah_pegawai,
        status: perusahaan.status ?? 'basic',
        expired_at: perusahaan.expired_at,
        id: perusahaan.id
    })

    console.log(values);

    const changeValue = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value });
    }
    const changeImage = (e) => {
        setUpdate(null);
        setValues({ ...values, logo: e.target.files[0] });
    }

    const saveData = async (e) => {
        e.preventDefault();
        Inertia.post(route('perusahaan.update'), values);
    }

    return (
        <div>
            <div className="toolbar mb-5 mb-lg-7 d-flex justify-content-between">
                <div className="page-title d-flex flex-column me-3">
                    <h1 className="d-flex text-dark fw-bolder my-1 fs-3">Perusahaan</h1>
                    <ul className="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                        <li className="breadcrumb-item text-gray-600">
                            <a href="/" className="text-gray-600 text-hover-primary">Home</a>
                        </li>
                        <li className="breadcrumb-item text-gray-500">Data</li>
                    </ul>
                </div>
                <div className="d-flex align-items-center py-2 py-md-1" >
                    <Link href={route('perusahaan.index')} className="btn btn-dark"><b>Kembali</b></Link>
                </div>
            </div>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Data perusahaan</span>
                    </h3>
                </div>
                <div className="card-body">
                    <form onSubmit={saveData}>
                        <div>
                            <div className="row">
                                <div className="col-lg-12 mb-4">
                                    <label htmlFor="nama" className="form-label required">Nama Perusahaan</label>
                                    <input type="text" name="nama" id="nama" required className="mt-1 form-control form-control-lg form-control-solid" onChange={changeValue} value={values.nama} />
                                    {errors.nama && <div className="text-danger">{errors.nama}</div>}
                                </div>
                                <div className="col-lg-12 mb-4">
                                    <label htmlFor="alamat" className="form-label required">Alamat Perusahaan</label>
                                    <textarea name="alamat" id="alamat" required className="mt-1 form-control form-control-lg form-control-solid" onChange={changeValue} value={values.alamat} rows="4" />
                                    {errors.alamat && <div className="text-danger">{errors.alamat}</div>}
                                </div>
                                <div className="col-lg-12 mb-4">
                                    <label htmlFor="kontak" className="form-label required">Kontak Perusahaan</label>
                                    <textarea name="kontak" id="kontak" required className="mt-1 form-control form-control-lg form-control-solid" onChange={changeValue} value={values.kontak} rows="4" />
                                    {errors.kontak && <div className="text-danger">{errors.kontak}</div>}
                                </div>
                                <div className="col-lg-12 mb-4">
                                    <label htmlFor="direktur" className="form-label required">Direktur Perusahaan</label>
                                    <input type="text" name="direktur" id="direktur" required className="mt-1 form-control form-control-lg form-control-solid" onChange={changeValue} value={values.direktur} />
                                    {errors.direktur && <div className="text-danger">{errors.direktur}</div>}
                                </div>
                                <div className="col-lg-12 mb-4">
                                    <label htmlFor="nomor" className="form-label">Nomor Pegawai Direktur</label>
                                    <input type="text" name="nomor" id="nomor" className="mt-1 form-control form-control-lg form-control-solid" onChange={changeValue} value={values.nomor} />
                                    {errors.nomor && <div className="text-danger">{errors.nomor}</div>}
                                </div>
                                <div className="col-lg-12 mb-4">
                                    <label htmlFor="status" className="form-label">Layanan</label>
                                    <select className="mt-1 form-control form-control-lg form-control-solid" onChange={changeValue} value={values.status}>
                                        <option value="basic">Basic (Rp. 2000 / Pegawai)</option>
                                        <option value="premium">Premium (Rp. 5000 / Pegawai)</option>
                                    </select>
                                    {errors.status && <div className="text-danger">{errors.status}</div>}
                                </div>
                                <div className="col-lg-6 mb-4">
                                    <label htmlFor="expired_at" className="form-label">Tanggal Expired</label>
                                    <input type="date" name="expired_at" id="expired_at" className="mt-1 form-control form-control-lg form-control-solid" onChange={changeValue} value={values.expired_at} />
                                    {errors.expired_at && <div className="text-danger">{errors.expired_at}</div>}
                                </div>
                                <div className="col-lg-6 mb-4">
                                    <label htmlFor="jumlah_pegawai" className="form-label">Jumlah Pegawai</label>
                                    <input type="number" min="0" name="jumlah_pegawai" id="jumlah_pegawai" className="mt-1 form-control form-control-lg form-control-solid" onChange={changeValue} value={values.jumlah_pegawai} />
                                    {errors.jumlah_pegawai && <div className="text-danger">{errors.jumlah_pegawai}</div>}
                                </div>
                                <div className="col-lg-12 mb-4">
                                    <label htmlFor="logo" className="form-label required">Logo Perusahaan</label>
                                    {
                                        values.logo == undefined || values.logo == '' ? ''
                                            :
                                            <div>
                                                <img src={update === null || update === undefined ? URL.createObjectURL(values.logo) : "/storage/" + values.logo} width={250} height={250} alt="logo" />
                                            </div>
                                    }
                                    <input onChange={changeImage} type="file" name="logo" id="logo" className="mt-1 form-control" />
                                {errors.logo && <div className="text-danger">{errors.logo}</div>}
                                </div>
                            </div>
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

Edit.layout = (page) => <Authenticated children={page} />