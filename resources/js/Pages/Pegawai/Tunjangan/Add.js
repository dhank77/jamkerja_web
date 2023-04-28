import Input from '@/Components/Crud/Input';
import Tunjangan from '@/Components/Select/Tunjangan';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link, usePage } from '@inertiajs/inertia-react';
import React, { useState } from 'react'
import NumberFormat from 'react-number-format';
import Detail from '../Pegawai/Detail';

export default function Add({ errors, pegawai, Rtunjangan }) {

    const [values, setValues] = useState({
        nilai: Rtunjangan.nilai,
        kode_tunjangan: Rtunjangan.kode_tunjangan,
        tanggal_sk: Rtunjangan.tanggal_sk,
        nomor_sk: Rtunjangan.nomor_sk,
        nilai: Rtunjangan.nilai,
        file: Rtunjangan.file,
        is_aktif: Rtunjangan.is_aktif,
        is_private: Rtunjangan.is_private,
        id: Rtunjangan.id,
    });

    const { auth } = usePage().props;

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    const changeSelect = (e, name) => {
        setValues({ ...values, [name]: e[name] })
    }

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('pegawai.tunjangan.store', pegawai.nip), values);
    }

    return (
        <Detail pegawai={pegawai}>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Tambah Riwayat tunjangan</span>
                    </h3>
                    <div class="card-toolbar">
                        <Link preserveScroll href={route('pegawai.tunjangan.index', pegawai.nip)} class="btn btn-dark fw-bolder me-auto px-4 py-3">Kembali</Link>
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
                                    <input class="form-check-input" checked={values.is_aktif == 1 ? true : false} onChange={updateData} name='is_aktif' type="radio" value="1" id="flexCheckbox1" />
                                    <label class="form-check-label  mr-10" for="flexCheckbox1">
                                        Aktif (Terhitung pada Payroll)
                                    </label>
                                </div>
                                <div class="form-check form-check-custom form-check-success form-check-solid form-check-lg">
                                    <input class="form-check-input" checked={values.is_aktif == 0 ? true : false} onChange={updateData} name='is_aktif' type="radio" value="0" id="flexCheckbox2" />
                                    <label class="form-check-label" for="flexCheckbox2">
                                        Tidak Aktif (Tidak terhitung pada Payroll)
                                    </label>
                                </div>
                            </div>
                            {errors.is_aktif && <div className="text-danger">{errors.is_aktif}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Jenis Tunjangan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <Tunjangan valueHandle={values.kode_tunjangan} onchangeHandle={(e) => changeSelect(e, 'kode_tunjangan')} />
                            </div>
                            {errors.kode_tunjangan && <div className="text-danger">{errors.kode_tunjangan}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Nominal</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <NumberFormat className="form-control" name="nilai" onChange={updateData} value={values.nilai} thousandSeparator={'.'} decimalSeparator={','} />
                            </div>
                            {errors.nilai && <div className="text-danger">{errors.nilai}</div>}
                        </div>
                        <Input name="tanggal_sk" type='date' required={false} values={values.tanggal_sk} onChangeHandle={updateData} />
                        <Input name="nomor_sk" required={true} values={values.nomor_sk} onChangeHandle={updateData} />
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