import Input from '@/Components/Crud/Input';
import JenisPmk from '@/Components/Select/JenisPmk';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useState } from 'react'
import Detail from '../Pegawai/Detail';

export default function Add({ errors, pegawai, Rpmk }) {

    const [values, setValues] = useState({
        jenis_pmk: Rpmk.jenis_pmk,
        instansi: Rpmk.instansi,
        tanggal_awal: Rpmk.tanggal_awal,
        tanggal_akhir: Rpmk.tanggal_akhir,
        nomor_sk: Rpmk.nomor_sk,
        tanggal_sk: Rpmk.tanggal_sk,
        masa_kerja_tahun: Rpmk.masa_kerja_tahun,
        masa_kerja_bulan: Rpmk.masa_kerja_bulan,
        file: Rpmk.file,
        id: Rpmk.id,
    });

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    const changeSelect = (e, name) => {
        setValues({ ...values, [name]: e[name] })
    }

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('pegawai.pmk.store', pegawai.nip), values);
    }

    return (
        <Detail pegawai={pegawai}>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Tambah Riwayat Pekerjaan</span>
                    </h3>
                    <div class="card-toolbar">
                        <Link preserveScroll href={route('pegawai.pmk.index', pegawai.nip)} class="btn btn-dark fw-bolder me-auto px-4 py-3">Kembali</Link>
                    </div>
                </div>
                <div className="card-body py-3">
                    <form onSubmit={submit}>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Jenis Perusahaan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <JenisPmk valueHandle={values.jenis_pmk} onchangeHandle={(e) => changeSelect(e, 'jenis_pmk')} />
                            </div>
                            {errors.jenis_pmk && <div className="text-danger">{errors.jenis_pmk}</div>}
                        </div>
                        <Input name="instansi" required={true} values={values.instansi} onChangeHandle={updateData} />
                        <Input name="tanggal_awal" type='date' required={true} values={values.tanggal_awal} onChangeHandle={updateData} />
                        <Input name="tanggal_akhir" type='date' required={true} values={values.tanggal_akhir} onChangeHandle={updateData} />
                        {/* <Input name="nomor_sk" type='text' required={true} values={values.nomor_sk} onChangeHandle={updateData} />
                        <Input name="tanggal_sk" type='date' required={true} values={values.tanggal_sk} onChangeHandle={updateData} /> */}
                        <div className="row mb-6">
                            <label className={`col-lg-3 col-form-label fw-bold fs-6 text-capitalize required`}>Masa Kerja</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <div className="row">
                                    <div className="col-lg-6">
                                        <div className='input-group input-group-solid'>
                                            <input name="masa_kerja_tahun" type="number" required
                                                onChange={updateData} value={values.masa_kerja_tahun} className="form-control  form-control-lg form-control-solid" />
                                            <span className="input-group-text">Tahun</span>
                                            {errors.masa_kerja_tahun && <div className="text-danger">{errors.masa_kerja_tahun}</div>}
                                        </div>
                                    </div>
                                    <div className="col-lg-6">
                                        <div className='input-group input-group-solid'>
                                            <input name="masa_kerja_bulan" type="number" required
                                                onChange={updateData} value={values.masa_kerja_bulan} className="form-control form-control-lg form-control-solid" />
                                            <span className="input-group-text">Bulan</span>
                                            {errors.masa_kerja_bulan && <div className="text-danger">{errors.masa_kerja_bulan}</div>}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label fw-bold fs-6">Unggah Dokumen</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                {
                                    values.file == undefined || values.file == '' ? ''
                                        : <a href={typeof (values.file) == 'object' ? URL.createObjectURL(values.file) : "/storage/" + values.file} className="badge badge-success mb-1 hover:text-gray-200 cursor-pointer" target="_blank">File Saat Ini</a>
                                }
                                <input type="file" accept="application/pdf" name="file" className="form-control p-3 border border-gray-200 rounded" onChange={e => setValues({ ...values, file: e.target.files[0] })} />

                            </div>
                            {errors.file && <div className="text-danger">{errors.file}</div>}
                        </div>

                        <div className="float-right">
                            <button type="submit" className="btn btn-primary">Simpan</button>
                        </div>

                    </form>

                </div>
            </div>

        </Detail>
    )
}

Add.layout = (page) => <Authenticated children={page} />