import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useEffect, useState } from 'react'

export default function Add({ errors }) {

    const [values, setValues] = useState({
        nama: '',
        data: [],
    })

    const [ahad, setAhad] = useState({
        'hari' : 0,
        'jam_datang' : '',
        'jam_pulang' : '',
        'istirahat' : '',
        'toleransi_datang' : '',
        'toleransi_pulang' : '',
    })
    const [senin, setSenin] = useState({
        'hari' : 1,
        'jam_datang' : '',
        'jam_pulang' : '',
        'istirahat' : '',
        'toleransi_datang' : '',
        'toleransi_pulang' : '',
    })
    const [selasa, setSelasa] = useState({
        'hari' : 2,
        'jam_datang' : '',
        'jam_pulang' : '',
        'istirahat' : '',
        'toleransi_datang' : '',
        'toleransi_pulang' : '',
    })
    const [rabu, setRabu] = useState({
        'hari' : 3,
        'jam_datang' : '',
        'jam_pulang' : '',
        'istirahat' : '',
        'toleransi_datang' : '',
        'toleransi_pulang' : '',
    })
    const [kamis, setKamis] = useState({
        'hari' : 4,
        'jam_datang' : '',
        'jam_pulang' : '',
        'istirahat' : '',
        'toleransi_datang' : '',
        'toleransi_pulang' : '',
    })
    const [jumat, setJumat] = useState({
        'hari' : 5,
        'jam_datang' : '',
        'jam_pulang' : '',
        'istirahat' : '',
        'toleransi_datang' : '',
        'toleransi_pulang' : '',
    })
    const [sabtu, setSabtu] = useState({
        'hari' : 6,
        'jam_datang' : '',
        'jam_pulang' : '',
        'istirahat' : '',
        'toleransi_datang' : '',
        'toleransi_pulang' : '',
    })

    const updateData = (e) =>  setValues({ ...values, [e.target.name]: e.target.value });

    const updateAhad = (e) =>  setAhad({ ...ahad, [e.target.name]: e.target.value });
    const updateSenin = (e) =>  setSenin({ ...senin, [e.target.name]: e.target.value });
    const updateSelasa = (e) =>  setSelasa({ ...selasa, [e.target.name]: e.target.value });
    const updateRabu = (e) =>  setRabu({ ...rabu, [e.target.name]: e.target.value });
    const updateKamis = (e) =>  setKamis({ ...kamis, [e.target.name]: e.target.value });
    const updateJumat = (e) =>  setJumat({ ...jumat, [e.target.name]: e.target.value });
    const updateSabtu = (e) =>  setSabtu({ ...sabtu, [e.target.name]: e.target.value });
    
    useEffect(() => setValues({...values, data : {...values.data, [0] : ahad, [1] : senin, [2] : selasa, [3] : rabu, [4] : kamis, [5] : jumat, [6] : sabtu }}) , [ahad, senin, selasa, rabu, kamis, jumat, sabtu])

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('master.jamKerjaStatis.store'), values);
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
                        <li className="breadcrumb-item text-gray-600">Jam Kerja Statis</li>
                        <li className="breadcrumb-item text-gray-500">Data</li>
                    </ul>
                </div>
                <div className="d-flex align-items-center py-2 py-md-1" >
                    <Link href={route('master.jamKerjaStatis.index')} className="btn btn-dark"><b>Kembali</b></Link>
                </div>
            </div>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Tambah Jam Kerja Statis</span>
                    </h3>
                </div>
                <div className="card-body py-3">
                    <form onSubmit={submit}>
                        <div className="row mb-6">
                            <h6 className="col-lg-3 required">Nama</h6>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input required name="nama" type="text" onChange={updateData} value={values.nama} className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.nama && <div className="text-danger">{errors.nama}</div>}
                        </div>
                        <div className="row mb-6">
                            <h6>Ahad</h6>
                            <div class="row">
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Jam Datang</label>
                                    <input required name="jam_datang" value={ahad.jam_datang} type="time" onChange={updateAhad} className="form-control form-control-lg form-control-solid" />
                                </div>
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Jam Pulang</label>
                                    <input required name="jam_pulang" type="time" onChange={updateAhad} value={ahad.jam_pulang} className="form-control form-control-lg form-control-solid" />
                                </div>
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Istirahat (Menit)</label>
                                    <input required name="istirahat" type="number" onChange={updateAhad} value={ahad.istirahat} className="form-control form-control-lg form-control-solid" />
                                </div>
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Toleransi Datang (Menit)</label>
                                    <input required name="toleransi_datang" type="number" onChange={updateAhad} value={ahad.toleransi_datang} className="form-control form-control-lg form-control-solid" />
                                </div>
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Toleransi Pulang (Menit)</label>
                                    <input required name="toleransi_pulang" type="number" onChange={updateAhad} value={ahad.toleransi_pulang} className="form-control form-control-lg form-control-solid" />
                                </div>
                            </div>
                        </div>
                        <div className="row mb-6">
                            <h6>Senin</h6>
                            <div class="row">
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Jam Datang</label>
                                    <input required name="jam_datang" value={senin.jam_datang} type="time" onChange={updateSenin} className="form-control form-control-lg form-control-solid" />
                                </div>
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Jam Pulang</label>
                                    <input required name="jam_pulang" type="time" onChange={updateSenin} value={senin.jam_pulang} className="form-control form-control-lg form-control-solid" />
                                </div>
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Istirahat (Menit)</label>
                                    <input required name="istirahat" type="number" onChange={updateSenin} value={senin.istirahat} className="form-control form-control-lg form-control-solid" />
                                </div>
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Toleransi Datang (Menit)</label>
                                    <input required name="toleransi_datang" type="number" onChange={updateSenin} value={senin.toleransi_datang} className="form-control form-control-lg form-control-solid" />
                                </div>
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Toleransi Pulang (Menit)</label>
                                    <input required name="toleransi_pulang" type="number" onChange={updateSenin} value={senin.toleransi_pulang} className="form-control form-control-lg form-control-solid" />
                                </div>
                            </div>
                        </div>
                        <div className="row mb-6">
                            <h6>Selasa</h6>
                            <div class="row">
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Jam Datang</label>
                                    <input required name="jam_datang" value={selasa.jam_datang} type="time" onChange={updateSelasa} className="form-control form-control-lg form-control-solid" />
                                </div>
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Jam Pulang</label>
                                    <input required name="jam_pulang" type="time" onChange={updateSelasa} value={selasa.jam_pulang} className="form-control form-control-lg form-control-solid" />
                                </div>
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Istirahat (Menit)</label>
                                    <input required name="istirahat" type="number" onChange={updateSelasa} value={selasa.istirahat} className="form-control form-control-lg form-control-solid" />
                                </div>
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Toleransi Datang (Menit)</label>
                                    <input required name="toleransi_datang" type="number" onChange={updateSelasa} value={selasa.toleransi_datang} className="form-control form-control-lg form-control-solid" />
                                </div>
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Toleransi Pulang (Menit)</label>
                                    <input required name="toleransi_pulang" type="number" onChange={updateSelasa} value={selasa.toleransi_pulang} className="form-control form-control-lg form-control-solid" />
                                </div>
                            </div>
                        </div>
                        <div className="row mb-6">
                            <h6>Rabu</h6>
                            <div class="row">
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Jam Datang</label>
                                    <input required name="jam_datang" value={rabu.jam_datang} type="time" onChange={updateRabu} className="form-control form-control-lg form-control-solid" />
                                </div>
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Jam Pulang</label>
                                    <input required name="jam_pulang" type="time" onChange={updateRabu} value={rabu.jam_pulang} className="form-control form-control-lg form-control-solid" />
                                </div>
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Istirahat (Menit)</label>
                                    <input required name="istirahat" type="number" onChange={updateRabu} value={rabu.istirahat} className="form-control form-control-lg form-control-solid" />
                                </div>
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Toleransi Datang (Menit)</label>
                                    <input required name="toleransi_datang" type="number" onChange={updateRabu} value={rabu.toleransi_datang} className="form-control form-control-lg form-control-solid" />
                                </div>
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Toleransi Pulang (Menit)</label>
                                    <input required name="toleransi_pulang" type="number" onChange={updateRabu} value={rabu.toleransi_pulang} className="form-control form-control-lg form-control-solid" />
                                </div>
                            </div>
                        </div>
                        <div className="row mb-6">
                            <h6>Kamis</h6>
                            <div class="row">
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Jam Datang</label>
                                    <input required name="jam_datang" value={kamis.jam_datang} type="time" onChange={updateKamis} className="form-control form-control-lg form-control-solid" />
                                </div>
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Jam Pulang</label>
                                    <input required name="jam_pulang" type="time" onChange={updateKamis} value={kamis.jam_pulang} className="form-control form-control-lg form-control-solid" />
                                </div>
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Istirahat (Menit)</label>
                                    <input required name="istirahat" type="number" onChange={updateKamis} value={kamis.istirahat} className="form-control form-control-lg form-control-solid" />
                                </div>
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Toleransi Datang (Menit)</label>
                                    <input required name="toleransi_datang" type="number" onChange={updateKamis} value={kamis.toleransi_datang} className="form-control form-control-lg form-control-solid" />
                                </div>
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Toleransi Pulang (Menit)</label>
                                    <input required name="toleransi_pulang" type="number" onChange={updateKamis} value={kamis.toleransi_pulang} className="form-control form-control-lg form-control-solid" />
                                </div>
                            </div>
                        </div>
                        <div className="row mb-6">
                            <h6>Jumat</h6>
                            <div class="row">
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Jam Datang</label>
                                    <input required name="jam_datang" value={jumat.jam_datang} type="time" onChange={updateJumat} className="form-control form-control-lg form-control-solid" />
                                </div>
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Jam Pulang</label>
                                    <input required name="jam_pulang" type="time" onChange={updateJumat} value={jumat.jam_pulang} className="form-control form-control-lg form-control-solid" />
                                </div>
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Istirahat (Menit)</label>
                                    <input required name="istirahat" type="number" onChange={updateJumat} value={jumat.istirahat} className="form-control form-control-lg form-control-solid" />
                                </div>
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Toleransi Datang (Menit)</label>
                                    <input required name="toleransi_datang" type="number" onChange={updateJumat} value={jumat.toleransi_datang} className="form-control form-control-lg form-control-solid" />
                                </div>
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Toleransi Pulang (Menit)</label>
                                    <input required name="toleransi_pulang" type="number" onChange={updateJumat} value={jumat.toleransi_pulang} className="form-control form-control-lg form-control-solid" />
                                </div>
                            </div>
                        </div>
                        <div className="row mb-6">
                            <h6>Sabtu</h6>
                            <div class="row">
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Jam Datang</label>
                                    <input required name="jam_datang" value={sabtu.jam_datang} type="time" onChange={updateSabtu} className="form-control form-control-lg form-control-solid" />
                                </div>
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Jam Pulang</label>
                                    <input required name="jam_pulang" type="time" onChange={updateSabtu} value={sabtu.jam_pulang} className="form-control form-control-lg form-control-solid" />
                                </div>
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Istirahat (Menit)</label>
                                    <input required name="istirahat" type="number" onChange={updateSabtu} value={sabtu.istirahat} className="form-control form-control-lg form-control-solid" />
                                </div>
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Toleransi Datang (Menit)</label>
                                    <input required name="toleransi_datang" type="number" onChange={updateSabtu} value={sabtu.toleransi_datang} className="form-control form-control-lg form-control-solid" />
                                </div>
                                <div className="col-lg fv-row fv-plugins-icon-container">
                                    <label>Toleransi Pulang (Menit)</label>
                                    <input required name="toleransi_pulang" type="number" onChange={updateSabtu} value={sabtu.toleransi_pulang} className="form-control form-control-lg form-control-solid" />
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

Add.layout = (page) => <Authenticated children={page} />