import Input from '@/Components/Crud/Input';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link, usePage } from '@inertiajs/inertia-react';
import React, { useState } from 'react'
import NumberFormat from 'react-number-format';
import Detail from '../Pegawai/Detail';

export default function Add({ errors, pegawai, Rkgb }) {

    const [values, setValues] = useState({
        nomor_surat: Rkgb.nomor_surat,
        tanggal_surat: Rkgb.tanggal_surat,
        tanggal_tmt: Rkgb.tanggal_tmt,
        gaji_pokok: Rkgb.gaji_pokok,
        masa_kerja_tahun: Rkgb.masa_kerja_tahun,
        masa_kerja_bulan: Rkgb.masa_kerja_bulan,
        is_akhir: Rkgb.is_akhir,
        is_private: Rkgb.is_private,
        file: Rkgb.file,
        id: Rkgb.id,
    });

    const { auth } = usePage().props;

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('pegawai.kgb.store', pegawai.nip), values);
    }

    return (
        <Detail pegawai={pegawai}>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Tambah Riwayat Gaji</span>
                    </h3>
                    <div class="card-toolbar">
                        <Link preserveScroll href={route('pegawai.kgb.index', pegawai.nip)} class="btn btn-dark fw-bolder me-auto px-4 py-3">Kembali</Link>
                    </div>
                </div>
                <div className="card-body py-3">
                    <form onSubmit={submit}>
                    {
                            auth.role.some(ar => ['owner'].includes(ar)) &&
                            <div className='row mb-6'>
                                <label className="col-lg-3 col-form-label required fw-bold fs-6">Apakah Data Ini Private ?</label>
                                <div className="col-lg-9 fv-row fv-plugins-icon-container d-flex">
                                    <div class="form-check form-check-custom form-check-success form-check-solid form-check-lg ">
                                        <input class="form-check-input" checked={values.is_private == 1 ? true : false} onChange={updateData} name='is_private' type="radio" value="1" id="flexCheckbox1" />
                                        <label class="form-check-label  mr-10" for="flexCheckbox1">
                                            Ya
                                        </label>
                                    </div>
                                    <div class="form-check form-check-custom form-check-success form-check-solid form-check-lg">
                                        <input class="form-check-input" checked={values.is_private == 0 ? true : false} onChange={updateData} name='is_private' type="radio" value="0" id="flexCheckbox2" />
                                        <label class="form-check-label" for="flexCheckbox2">
                                            Tidak
                                        </label>
                                    </div>
                                </div>
                                {errors.is_private && <div className="text-danger">{errors.is_private}</div>}
                            </div>
                        }
                        <div className='row mb-6'>
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Pilihan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container d-flex">
                                <div class="form-check form-check-custom form-check-success form-check-solid form-check-lg ">
                                    <input class="form-check-input" checked={values.is_akhir == 1 ? true : false} onChange={updateData} name='is_akhir' type="radio" value="1" id="flexCheckbox1" />
                                    <label class="form-check-label  mr-10" for="flexCheckbox1">
                                        Gaji Akhir
                                    </label>
                                </div>
                                <div class="form-check form-check-custom form-check-success form-check-solid form-check-lg">
                                    <input class="form-check-input" checked={values.is_akhir == 0 ? true : false} onChange={updateData} name='is_akhir' type="radio" value="0" id="flexCheckbox2" />
                                    <label class="form-check-label" for="flexCheckbox2">
                                        Riwayat Gaji
                                    </label>
                                </div>
                            </div>
                            {errors.is_akhir && <div className="text-danger">{errors.is_akhir}</div>}
                        </div>
                        <Input name="nomor_surat" required={true} values={values.nomor_surat} onChangeHandle={updateData} />
                        <Input name="tanggal_surat" type='date' required={true} values={values.tanggal_surat} onChangeHandle={updateData} />
                        <Input name="tanggal_tmt" type='date' required={true} values={values.tanggal_tmt} onChangeHandle={updateData} />
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label fw-bold fs-6">Gaji Pokok Baru</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <NumberFormat name="gaji_pokok" value={values.gaji_pokok} onChange={updateData} className="form-control form-control-lg form-control-solid" required thousandSeparator={'.'} decimalSeparator={','} />
                            </div>
                            {errors.gaji_pokok && <div className="text-danger">{errors.gaji_pokok}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className={`col-lg-3 col-form-label fw-bold fs-6 text-capitalize`}>Masa Kerja</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <div className="row">
                                    <div className="col-lg-6">
                                        <div className='input-group input-group-solid'>
                                            <input name="masa_kerja_tahun" type="number"
                                                onChange={updateData} value={values.masa_kerja_tahun} className="form-control form-control-lg form-control-solid" />
                                            <span className="input-group-text">Tahun</span>
                                            {errors.masa_kerja_tahun && <div className="text-danger">{errors.masa_kerja_tahun}</div>}
                                        </div>
                                    </div>
                                    <div className="col-lg-6">
                                        <div className='input-group input-group-solid'>
                                            <input name="masa_kerja_bulan" type="number"
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