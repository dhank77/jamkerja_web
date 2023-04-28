import Input from '@/Components/Crud/Input';
import Reimbursement from '@/Components/Select/Reimbursement';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useState } from 'react'
import NumberFormat from 'react-number-format';
import Detail from '../Pegawai/Detail';

export default function Add({ errors, pegawai, Rreimbursement }) {

    const [values, setValues] = useState({
        nilai: Rreimbursement.nilai,
        kode_reimbursement: Rreimbursement.kode_reimbursement,
        tanggal_surat: Rreimbursement.tanggal_surat,
        nomor_surat: Rreimbursement.nomor_surat,
        keterangan: Rreimbursement.keterangan,
        file: Rreimbursement.file,
        id: Rreimbursement.id,
    });

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    const changeSelect = (e, name) => {
        setValues({ ...values, [name]: e[name] })
    }

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('pegawai.reimbursement.store', pegawai.nip), values);
    }

    return (
        <Detail pegawai={pegawai}>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Tambah Riwayat reimbursement</span>
                    </h3>
                    <div class="card-toolbar">
                        <Link preserveScroll href={route('pegawai.reimbursement.index', pegawai.nip)} class="btn btn-dark fw-bolder me-auto px-4 py-3">Kembali</Link>
                    </div>
                </div>
                <div className="card-body py-3">
                    <form onSubmit={submit}>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Reimbursement</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                            <Reimbursement valueHandle={values.kode_reimbursement} onchangeHandle={(e) => changeSelect(e, 'kode_reimbursement')} />
                            </div>
                            {errors.kode_reimbursement && <div className="text-danger">{errors.kode_reimbursement}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Nominal</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <NumberFormat className="form-control" name="nilai" onChange={updateData} value={values.nilai} thousandSeparator={'.'} decimalSeparator={','} />
                            </div>
                            {errors.nilai && <div className="text-danger">{errors.nilai}</div>}
                        </div>
                        <Input name="keterangan" required={false} values={values.keterangan} onChangeHandle={updateData} />
                        <Input name="tanggal_surat" type='date' required={false} values={values.tanggal_surat} onChangeHandle={updateData} />
                        <Input name="nomor_surat" required={true} values={values.nomor_surat} onChangeHandle={updateData} />
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