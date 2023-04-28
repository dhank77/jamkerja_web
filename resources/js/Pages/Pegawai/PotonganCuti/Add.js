import Input from '@/Components/Crud/Input';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useState } from 'react'
import Year from '@/Components/Date/Year';
import Select from 'react-select';
import Detail from '../Pegawai/Detail';
import JenisPotonganCuti from '@/Components/Select/JenisPotonganCuti';

export default function Add({ errors, pegawai, Rpcuti }) {

    const [values, setValues] = useState({
        hari: Rpcuti.hari,
        tahun: Rpcuti.tahun,
        keterangan: Rpcuti.keterangan,
        file: Rpcuti.file,
        id: Rpcuti.id,
    });

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    const changeSelect = (e, name) => {
        setValues({ ...values, [name]: e[name] })
    }

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('pegawai.pcuti.store', pegawai.nip), values);
    }

    return (
        <Detail pegawai={pegawai}>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Tambah Data</span>
                    </h3>
                    <div class="card-toolbar">
                        <Link preserveScroll href={route('pegawai.potongan.index', pegawai.nip)} class="btn btn-dark fw-bolder me-auto px-4 py-3">Kembali</Link>
                    </div>
                </div>
                <div className="card-body py-3">
                    <form onSubmit={submit}>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Keterangan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <JenisPotonganCuti valueHandle={values.keterangan} onchangeHandle={(e) => changeSelect(e, 'keterangan')} />
                            </div>
                            {errors.keterangan && <div className="text-danger">{errors.keterangan}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Tahun</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <Year filterTahun={(e) => changeSelect(e, 'tahun')} value={values.tahun} />
                            </div>
                            {errors.tahun && <div className="text-danger">{errors.tahun}</div>}
                        </div>
                        <Input name="hari" type='number' values={values.hari} onChangeHandle={updateData} />
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