import Bidang from '@/Components/Select/Bidang';
import JenisJabatan from '@/Components/Select/JenisJabatan';
import Seksi from '@/Components/Select/Seksi';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useEffect, useState } from 'react'
import Select from 'react-select';

export default function Add({ errors, jabatan, skpd, eselon }) {

    const [values, setValues] = useState({
        kode_skpd: jabatan.kode_skpd,
        kode_bidang: jabatan.kode_bidang,
        kode_seksi: jabatan.kode_seksi,
        kode_atasan: jabatan.kode_atasan,
        nama: jabatan.nama,
        kode_jabatan: jabatan.kode_jabatan,
        kode_eselon: jabatan.kode_eselon,
        jenis_jabatan: jabatan.jenis_jabatan,
        batas_pensiun: jabatan.batas_pensiun,
        kelas_jabatan: jabatan.kelas_jabatan,
        kebutuhan: jabatan.kebutuhan,
        id: jabatan.id,
    });

    const [atasan, setAtasan] = useState([])

    const { data: skpdS } = skpd;
    const { data: eselonS } = eselon;

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    const changeSelect = (e, name) => {
        setValues({ ...values, [name]: e[name] })
    }
    
    useEffect(() => {
        if(values.kode_skpd != undefined){
            getAtasan(values.kode_skpd);
        }
    }, [values.kode_skpd])
    

    const getAtasan = async (id) => {
        try {
            let { data } = await axios.get(route('master.jabatan.atasan', id));
            setAtasan(data);
        } catch (error) {
            console.log(error);
        }
    }

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('master.jabatan.store'), values);
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
                        <li className="breadcrumb-item text-gray-600">Jabatan</li>
                        <li className="breadcrumb-item text-gray-500">Data</li>
                    </ul>
                </div>
                <div className="d-flex align-items-center py-2 py-md-1" >
                    <Link href={route('master.jabatan.index')} className="btn btn-dark"><b>Kembali</b></Link>
                </div>
            </div>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Tambah SKPD</span>
                    </h3>
                </div>
                <div className="card-body py-3">
                    <form onSubmit={submit}>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">SKPD</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <Select defaultValue={skpdS.filter(obj => (obj.kode_skpd == values.kode_skpd))} options={skpdS} onChange={(e) => changeSelect(e, 'kode_skpd')} />
                            </div>
                            {errors.kode_skpd && <div className="text-danger">{errors.kode_skpd}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Bidang</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <Bidang skpd={values.kode_skpd} onchangeHandle={(e) => changeSelect(e, 'kode_bidang')} valueHandle={values.kode_bidang} />
                            </div>
                            {errors.kode_bidang && <div className="text-danger">{errors.kode_bidang}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Seksi</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <Seksi bidang={values.kode_bidang} onchangeHandle={(e) => changeSelect(e, 'kode_seksi')} valueHandle={values.kode_seksi} />
                            </div>
                            {errors.kode_seksi && <div className="text-danger">{errors.kode_seksi}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Jabatan Atasan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <Select value={atasan.filter(obj => (obj.kode_atasan == values.kode_atasan))} options={atasan} onChange={(e) => changeSelect(e, 'kode_atasan')} />
                            </div>
                            {errors.kode_atasan && <div className="text-danger">{errors.kode_atasan}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Jenis Jabatan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <JenisJabatan valueHandle={values.jenis_jabatan} onchangeHandle={(e) => changeSelect(e, 'jenis_jabatan')} />
                            </div>
                            {errors.jenis_jabatan && <div className="text-danger">{errors.jenis_jabatan}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Kode Jabatan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="kode_jabatan" disabled={values.id != undefined ? true : false} type="text" onChange={updateData} value={values.kode_jabatan} className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.kode_jabatan && <div className="text-danger">{errors.kode_jabatan}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Nama Jabatan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="nama" type="text" onChange={updateData} value={values.nama} className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.nama && <div className="text-danger">{errors.nama}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Eselon</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <Select defaultValue={eselonS.filter(obj => (obj.kode_eselon == values.kode_eselon))} options={eselonS} onChange={(e) => changeSelect(e, 'kode_eselon')} />
                            </div>
                            {errors.kode_eselon && <div className="text-danger">{errors.kode_eselon}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label fw-bold fs-6">Batas Usia Pensiun</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="batas_pensiun" type="number" onChange={updateData} value={values.batas_pensiun} className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.batas_pensiun && <div className="text-danger">{errors.batas_pensiun}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label fw-bold fs-6">Kelas Jabatan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="kelas_jabatan" type="number" onChange={updateData} value={values.kelas_jabatan} className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.kelas_jabatan && <div className="text-danger">{errors.kelas_jabatan}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label fw-bold fs-6">Kebutuhan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="kebutuhan" type="number" onChange={updateData} value={values.kebutuhan} className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.kebutuhan && <div className="text-danger">{errors.kebutuhan}</div>}
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