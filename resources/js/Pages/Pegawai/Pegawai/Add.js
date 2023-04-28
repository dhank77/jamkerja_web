import Agama from '@/Components/Select/Agama';
import GolonganDarah from '@/Components/Select/GolonganDarah';
import JenisKelamin from '@/Components/Select/JenisKelamin';
import Kawin from '@/Components/Select/Kawin';
import StatusPegawai from '@/Components/Select/StatusPegawai';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useState } from 'react'

export default function Add({ errors, pegawai }) {

    const [values, setValues] = useState({
        id_pns: pegawai.id_pns,
        nip: pegawai.nip,
        nik: pegawai.nik,
        name: pegawai.name,
        gelar_depan: pegawai.gelar_depan,
        gelar_belakang: pegawai.gelar_belakang,
        tempat_lahir: pegawai.tempat_lahir,
        tanggal_lahir: pegawai.tanggal_lahir,
        kode_pegawai: pegawai.kode_pegawai,
        kode_agama: pegawai.kode_agama,
        kode_status: pegawai.kode_status,
        kode_kawin: pegawai.kode_kawin,
        jenis_kelamin: pegawai.jenis_kelamin,
        golongan_darah: pegawai.golongan_darah,
        alamat: pegawai.alamat,
        alamat_ktp: pegawai.alamat_ktp,
        email: pegawai.email,
        no_hp: pegawai.no_hp,
        id: pegawai.id,
    })

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }
    
    const changeSelect = (e, name) => {
        setValues({ ...values, [name]: e[name] })
    }

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('pegawai.pegawai.store'), values);
    }

    return (
        <div>
            <div className="toolbar mb-5 mb-lg-7">
                <div className="page-title d-flex flex-column me-3">
                    <h1 className="d-flex text-dark fw-bolder my-1 fs-3">Pegawai</h1>
                    <ul className="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                        <li className="breadcrumb-item text-gray-600">
                            <a href="/" className="text-gray-600 text-hover-primary">Home</a>
                        </li>
                        <li className="breadcrumb-item text-gray-600">Data</li>
                        <li className="breadcrumb-item text-gray-500">Data</li>
                    </ul>
                </div>
                <div className="d-flex align-items-center py-2 py-md-1" >
                    <Link href={route('pegawai.pegawai.index')} className="btn btn-dark"><b>Kembali</b></Link>
                </div>
            </div>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Tambah pegawai</span>
                    </h3>
                </div>
                <div className="card-body py-3">
                    <form onSubmit={submit}>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Nomor Pegawai</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="nip" disabled={values.id != undefined ? true : false} type="number" onChange={updateData} value={values.nip} className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.nip && <div className="text-danger">{errors.nip}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Nomor KTP</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="nik" disabled={values.id != undefined ? true : false} type="number" onChange={updateData} value={values.nik} className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.nik && <div className="text-danger">{errors.nik}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Nama Lengkap</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="name" type="text" onChange={updateData} value={values.name} className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.name && <div className="text-danger">{errors.name}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label fw-bold fs-6">Gelar depan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="gelar_depan" type="text" onChange={updateData} value={values.gelar_depan} className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.gelar_depan && <div className="text-danger">{errors.gelar_depan}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label fw-bold fs-6">Gelar belakang</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="gelar_belakang" type="text" onChange={updateData} value={values.gelar_belakang} className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.gelar_belakang && <div className="text-danger">{errors.gelar_belakang}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Tempat lahir</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="tempat_lahir" type="text" onChange={updateData} value={values.tempat_lahir} className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.tempat_lahir && <div className="text-danger">{errors.tempat_lahir}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Tanggal lahir</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="tanggal_lahir" type="date" onChange={updateData} value={values.tanggal_lahir} className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.tanggal_lahir && <div className="text-danger">{errors.tanggal_lahir}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Jenis Kelamin</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <JenisKelamin onchangeHandle={(e) => changeSelect(e, 'jenis_kelamin')} valueHandle={values.jenis_kelamin} />
                            </div>
                            {errors.jenis_kelamin && <div className="text-danger">{errors.jenis_kelamin}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Agama</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <Agama onchangeHandle={(e) => changeSelect(e, 'kode_agama')} valueHandle={values.kode_agama} />
                            </div>
                            {errors.kode_agama && <div className="text-danger">{errors.kode_agama}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Status Pegawai</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <StatusPegawai onchangeHandle={(e) => changeSelect(e, 'kode_status')} valueHandle={values.kode_status} />
                            </div>
                            {errors.kode_status && <div className="text-danger">{errors.kode_status}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Status Pernikahan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <Kawin onchangeHandle={(e) => changeSelect(e, 'kode_kawin')} valueHandle={values.kode_kawin} />
                            </div>
                            {errors.kode_kawin && <div className="text-danger">{errors.kode_kawin}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label fw-bold fs-6">Golongan Darah</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <GolonganDarah onchangeHandle={(e) => changeSelect(e, 'golongan_darah')} valueHandle={values.golongan_darah} />
                            </div>
                            {errors.golongan_darah && <div className="text-danger">{errors.golongan_darah}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Alamat Domisili</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <textarea onChange={updateData}  name="alamat" id="alamat" cols="30" rows="4" value={values.alamat} className="form-control" />
                            </div>
                            {errors.alamat && <div className="text-danger">{errors.alamat}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Alamat Sesuai KTP</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <textarea onChange={updateData}  name="alamat_ktp" id="alamat_ktp" cols="30" rows="4" value={values.alamat_ktp} className="form-control" />
                            </div>
                            {errors.alamat_ktp && <div className="text-danger">{errors.alamat_ktp}</div>}
                        </div>
                        <div className="separator my-6" />
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">No Telepon / WA</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="no_hp" type="text" onChange={updateData} value={values.no_hp} className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.no_hp && <div className="text-danger">{errors.no_hp}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Email</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="email" type="text" onChange={updateData} value={values.email} className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.email && <div className="text-danger">{errors.email}</div>}
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