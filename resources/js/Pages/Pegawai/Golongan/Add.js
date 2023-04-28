import Input from '@/Components/Crud/Input';
import Golongan from '@/Components/Select/Golongan';
import JenisKp from '@/Components/Select/JenisLokasi';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useState } from 'react'
import Detail from '../Pegawai/Detail';

export default function Add({ errors, pegawai, Rgolongan }) {

    const [values, setValues] = useState({
        kode_golongan: Rgolongan.kode_golongan,
        kode_kp: Rgolongan.kode_kp,
        no_sk: Rgolongan.no_sk,
        tanggal_sk: Rgolongan.tanggal_sk,
        tanggal_tmt: Rgolongan.tanggal_tmt,
        sk_bkn: Rgolongan.sk_bkn,
        tanggal_bkn: Rgolongan.tanggal_bkn,
        masa_tahun: Rgolongan.masa_tahun,
        masa_bulan: Rgolongan.masa_bulan,
        file: Rgolongan.file,
        is_akhir: Rgolongan.is_akhir,
        id: Rgolongan.id,
    });

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    const changeSelect = (e, name) => {
        setValues({ ...values, [name]: e[name] })
    }

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('pegawai.golongan.store', pegawai.nip), values);
    }

    return (
        <Detail pegawai={pegawai}>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Tambah Riwayat golongan</span>
                    </h3>
                    <div class="card-toolbar">
                        <Link preserveScroll href={route('pegawai.golongan.index', pegawai.nip)} class="btn btn-dark fw-bolder me-auto px-4 py-3">Kembali</Link>
                    </div>
                </div>
                <div className="card-body py-3">
                    <form onSubmit={submit}>
                        <div className='row mb-6'>
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Pilihan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container d-flex">
                                <div class="form-check form-check-custom form-check-success form-check-solid form-check-lg ">
                                    <input class="form-check-input" checked={values.is_akhir == 1 ? true : false} onChange={updateData} name='is_akhir' type="radio" value="1" id="flexCheckbox1" />
                                    <label class="form-check-label  mr-10" for="flexCheckbox1">
                                        Golongan Akhir
                                    </label>
                                </div>
                                <div class="form-check form-check-custom form-check-success form-check-solid form-check-lg">
                                    <input class="form-check-input" checked={values.is_akhir == 0 ? true : false} onChange={updateData} name='is_akhir' type="radio" value="0" id="flexCheckbox2" />
                                    <label class="form-check-label" for="flexCheckbox2">
                                        Riwayat golongan
                                    </label>
                                </div>
                            </div>
                            {errors.is_akhir && <div className="text-danger">{errors.is_akhir}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Golongan - Pangkat</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <Golongan valueHandle={values.kode_golongan} onchangeHandle={(e) => changeSelect(e, 'kode_golongan')} />
                            </div>
                            {errors.kode_golongan && <div className="text-danger">{errors.kode_golongan}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Jenis KP</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <JenisKp valueHandle={values.kode_kp} onchangeHandle={(e) => changeSelect(e, 'kode_kp')} />
                            </div>
                            {errors.kode_kp && <div className="text-danger">{errors.kode_kp}</div>}
                        </div>
                        <Input name="no_sk" required={true} values={values.no_sk} onChangeHandle={updateData} />
                        <Input name="tanggal_sk" type='date' required={true} values={values.tanggal_sk} onChangeHandle={updateData} />
                        <Input name="tanggal_tmt" type='date' required={true} values={values.tanggal_tmt} onChangeHandle={updateData} />
                        <Input name="sk_bkn" type='text' required={false} values={values.sk_bkn} onChangeHandle={updateData} />
                        <Input name="tanggal_bkn" type='date' required={false} values={values.tanggal_bkn} onChangeHandle={updateData} />
                        <Input name="masa_bulan" type='number' required={false} values={values.masa_bulan} onChangeHandle={updateData} />
                        <Input name="masa_tahun" type='number' required={false} values={values.masa_tahun} onChangeHandle={updateData} />
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