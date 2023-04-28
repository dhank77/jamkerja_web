import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useState } from 'react'

export default function Edit({ errors, pengumuman }) {

    const [values, setValues] = useState({
        judul: pengumuman.judul,
        file: pengumuman.file,
        deskripsi: pengumuman.deskripsi,
        id: pengumuman.id
    })

    const changeValue = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value });
    }

    const saveData = async (e) => {
        e.preventDefault();
        Inertia.post(route('pengumuman.store'), values);
    }

    return (
        <div>
            <div className="toolbar mb-5 mb-lg-7">
                <div className="page-title d-flex flex-column me-3">
                    <h1 className="d-flex text-dark fw-bolder my-1 fs-3">Pengumuman</h1>
                    <ul className="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                        <li className="breadcrumb-item text-gray-600">
                            <a href="/" className="text-gray-600 text-hover-primary">Home</a>
                        </li>
                        <li className="breadcrumb-item text-gray-500">Data</li>
                    </ul>
                </div>
                <div className="d-flex align-items-center py-2 py-md-1" >
                    <Link href={route('pengumuman.index')} className="btn btn-dark"><b>Kembali</b></Link>
                </div>
            </div>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Data Pengumuman</span>
                    </h3>
                </div>
                <div className="card-body">
                    <form onSubmit={saveData}>
                        <div>
                            <div className="row">
                                <div className="col-lg-12 mb-4">
                                    <label htmlFor="judul" className="form-label required">Judul</label>
                                    <input type="text" name="judul" id="judul" required className="mt-1 form-control form-control-lg form-control-solid" onChange={changeValue} value={values.judul} />
                                    {errors.judul && <div className="text-danger">{errors.judul}</div>}
                                </div>
                                <div className="col-lg-12 mb-4">
                                    <label htmlFor="deskripsi" className="form-label required">Deskripsi</label>
                                    <textarea name="deskripsi" id="deskripsi" required className="mt-1 form-control form-control-lg form-control-solid" onChange={changeValue} value={values.deskripsi} rows="4" />
                                    {errors.deskripsi && <div className="text-danger">{errors.deskripsi}</div>}
                                </div>
                                <div className="col-lg-12 mb-4">
                                    <label htmlFor="file" className="form-label required">PDF / Gambar</label>
                                    {
                                        values.file == undefined || values.file == '' ? ''
                                            : <div>
                                                <a href={values.id === undefined || values.id === null ? URL.createObjectURL(values.file) : "/storage/" + values.file} className="badge badge-success" target="_blank">File Saat Ini</a>
                                            </div>
                                    }
                                    <input onChange={e => setValues({ ...values, file: e.target.files[0] })} type="file" name="file" id="file" className="mt-1 form-control" />
                                    {errors.file && <div className="text-danger">{errors.file}</div>}
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