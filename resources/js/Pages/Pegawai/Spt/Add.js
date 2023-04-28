import Input from '@/Components/Crud/Input';
import Year from '@/Components/Date/Year';
import JenisSpt from '@/Components/Select/JenisSpt';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useState } from 'react'
import NumberFormat from 'react-number-format';
import Detail from '../Pegawai/Detail';

export default function Add({ errors, pegawai, Rspt }) {

    const [values, setValues] = useState({
        tahun: Rspt.tahun,
        jenis_spt: Rspt.jenis_spt,
        status_spt: Rspt.status_spt,
        tanggal_penyampaian: Rspt.tanggal_penyampaian,
        nominal: Rspt.nominal,
        nomor_tanda_terima_elektronik: Rspt.nomor_tanda_terima_elektronik,
        file: Rspt.file,
        id: Rspt.id,
    });

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    const changeSelect = (e, name) => {
        setValues({ ...values, [name]: e[name] })
    }

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('pegawai.spt.store', pegawai.nip), values);
    }

    return (
        <Detail pegawai={pegawai}>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Tambah Riwayat spt</span>
                    </h3>
                    <div class="card-toolbar">
                        <Link preserveScroll href={route('pegawai.spt.index', pegawai.nip)} class="btn btn-dark fw-bolder me-auto px-4 py-3">Kembali</Link>
                    </div>
                </div>
                <div className="card-body py-3">
                    <form onSubmit={submit}>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Tahun</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <Year filterTahun={(e) => changeSelect(e, 'tahun')} value={values.tahun} />
                            </div>
                            {errors.tahun && <div className="text-danger">{errors.tahun}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Jenis Spt</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <JenisSpt valueHandle={values.jenis_spt} onchangeHandle={(e) => changeSelect(e, 'jenis_spt')} />
                            </div>
                            {errors.jenis_spt && <div className="text-danger">{errors.jenis_spt}</div>}
                        </div>
                        <Input name="status_spt" required={false} values={values.status_spt} onChangeHandle={updateData} />
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label fw-bold fs-6">Nominal</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <div className='input-group input-group-solid'>
                                    <span className="input-group-text">RP.</span>
                                    <NumberFormat name="nominal" value={values.nominal} onChange={updateData} className="form-control form-control-lg form-control-solid" required thousandSeparator={'.'} decimalSeparator={','} />
                                </div>
                            </div>
                            {errors.nominal && <div className="text-danger">{errors.nominal}</div>}
                        </div>
                        <Input name="tanggal_penyampaian" type='date' required={true} values={values.tanggal_penyampaian} onChangeHandle={updateData} />
                        <Input name="nomor_tanda_terima_elektronik" required={true} values={values.nomor_tanda_terima_elektronik} onChangeHandle={updateData} />
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