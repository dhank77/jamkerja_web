import Input from '@/Components/Crud/Input';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useState } from 'react'
import Detail from '../Pegawai/Detail';
import Keluarga from '@/Components/Select/keluarga';

export default function Add({ errors, pegawai, keluarga, status }) {
    const [values, setValues] = useState({
        status: keluarga.status ?? status,
        nip_keluarga: keluarga.nip_keluarga,
        nama: keluarga.nama,
        tempat_lahir: keluarga.tempat_lahir,
        tanggal_lahir: keluarga.tanggal_lahir,
        nomor_telepon: keluarga.nomor_telepon,
        alamat: keluarga.alamat,
        nomor_ktp: keluarga.nomor_ktp,
        file_ktp: keluarga.file_ktp,
        nomor_bpjs: keluarga.nomor_bpjs,
        file_bpjs: keluarga.file_bpjs,
        nomor_akta_kelahiran: keluarga.nomor_akta_kelahiran,
        file_akta_kelahiran: keluarga.file_akta_kelahiran,
        id: keluarga.id,
    });

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    const changeSelect = (e, name) => {
        setValues({ ...values, [name]: e[name] })
    }

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('pegawai.keluarga.store', pegawai.nip), values);
    }

    return (
        <Detail pegawai={pegawai}>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Tambah keluarga</span>
                    </h3>
                    <div class="card-toolbar">
                        <Link preserveScroll href={route('pegawai.keluarga.index', pegawai.nip)} class="btn btn-dark fw-bolder me-auto px-4 py-3">Kembali</Link>
                    </div>
                </div>
                <div className="card-body py-3">
                    <form onSubmit={submit}>
                        {
                            (status == "0" || status == "orang-tua") ?
                            <div className="row mb-6">
                                <label className="col-lg-3 col-form-label required fw-bold fs-6">Status Hubungan</label>
                                <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                    <Keluarga valueHandle={values.status} onchangeHandle={(e) => changeSelect(e, 'status')} tambah={status} />
                                </div>
                                {errors.status && <div className="text-danger">{errors.status}</div>}
                            </div>
                            :
                            <div className="row mb-6">
                                <label className="col-lg-3 col-form-label required fw-bold fs-6">Status Hubungan</label>
                                <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                    <input type="text" readOnly={true} value={status} className="form-control form-control-lg form-control-solid"/>
                                </div>
                                {errors.status && <div className="text-danger">{errors.status}</div>}
                            </div>

                        }
                        <Input name="nama" required={true} values={values.nama} onChangeHandle={updateData} />
                        <Input name="tempat_lahir" required={true} values={values.tempat_lahir} onChangeHandle={updateData} />
                        <Input name="tanggal_lahir" type='date' required={true} values={values.tanggal_lahir} onChangeHandle={updateData} />
                        <Input name="nomor_telepon" required={false} values={values.nomor_telepon} onChangeHandle={updateData} />
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label fw-bold fs-6">Alamat</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <textarea onChange={updateData}  name="alamat" id="alamat" cols="30" rows="4" value={values.alamat} className="form-control" />
                            </div>
                            {errors.alamat && <div className="text-danger">{errors.alamat}</div>}
                        </div>
                        <Input name="nomor_ktp" required={false} values={values.nomor_ktp} onChangeHandle={updateData} />
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label fw-bold fs-6">Unggah Ktp</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                {
                                    values.file_ktp == undefined || values.file_ktp == '' ? ''
                                        : <a href={typeof (values.file_ktp) == 'object' ? URL.createObjectURL(values.file_ktp) : "/storage/" + values.file_ktp} className="badge badge-success mb-1 hover:text-gray-200 cursor-pointer" target="_blank">File Saat Ini</a>
                                }
                                <input type="file" accept="application/pdf" name="file_ktp" className="form-control p-3 border border-gray-200 rounded" onChange={e => setValues({ ...values, file_ktp: e.target.files[0] })} />

                            </div>
                            {errors.file_ktp && <div className="text-danger">{errors.file_ktp}</div>}
                        </div>
                        <Input name="nomor_bpjs" required={false} values={values.nomor_bpjs} onChangeHandle={updateData} />
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label fw-bold fs-6">Unggah Bpjs</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                {
                                    values.file_bpjs == undefined || values.file_bpjs == '' ? ''
                                        : <a href={typeof (values.file_bpjs) == 'object' ? URL.createObjectURL(values.file_bpjs) : "/storage/" + values.file_bpjs} className="badge badge-success mb-1 hover:text-gray-200 cursor-pointer" target="_blank">File Saat Ini</a>
                                }
                                <input type="file" accept="application/pdf" name="file_bpjs" className="form-control p-3 border border-gray-200 rounded" onChange={e => setValues({ ...values, file_bpjs: e.target.files[0] })} />

                            </div>
                            {errors.file_bpjs && <div className="text-danger">{errors.file_bpjs}</div>}
                        </div>
                        {/* <Input name="nomor_akta_kelahiran" required={false} values={values.nomor_akta_kelahiran} onChangeHandle={updateData} />
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Unggah Akta Kelahiran</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                {
                                    values.file_akta_kelahiran == undefined || values.file_akta_kelahiran == '' ? ''
                                        : <a href={typeof (values.file_akta_kelahiran) == 'object' ? URL.createObjectURL(values.file_akta_kelahiran) : "/storage/" + values.file_akta_kelahiran} className="badge badge-success mb-1 hover:text-gray-200 cursor-pointer" target="_blank">File Saat Ini</a>
                                }
                                <input type="file" accept="application/pdf" name="file_akta_kelahiran" className="form-control p-3 border border-gray-200 rounded" onChange={e => setValues({ ...values, file_akta_kelahiran: e.target.files[0] })} />

                            </div>
                            {errors.file_akta_kelahiran && <div className="text-danger">{errors.file_akta_kelahiran}</div>}
                        </div> */}

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