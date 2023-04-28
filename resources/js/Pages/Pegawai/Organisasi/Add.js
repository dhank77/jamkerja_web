import Input from '@/Components/Crud/Input';
import JenisOrganisasi from '@/Components/Select/JenisOrganisasi';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useState } from 'react'
import Detail from '../Pegawai/Detail';

export default function Add({ errors, pegawai, Rorganisasi }) {

    const [values, setValues] = useState({
        nama_organisasi: Rorganisasi.nama_organisasi,
        jenis_organisasi: Rorganisasi.jenis_organisasi,
        jabatan: Rorganisasi.jabatan,
        tanggal_mulai: Rorganisasi.tanggal_mulai,
        tanggal_selesai: Rorganisasi.tanggal_selesai,
        nama_pimpinan: Rorganisasi.nama_pimpinan,
        tempat: Rorganisasi.tempat,
        file: Rorganisasi.file,
        id: Rorganisasi.id,
    });

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    const changeSelect = (e, name) => {
        setValues({ ...values, [name]: e[name] })
    }

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('pegawai.organisasi.store', pegawai.nip), values);
    }

    return (
        <Detail pegawai={pegawai}>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Tambah Riwayat organisasi</span>
                    </h3>
                    <div class="card-toolbar">
                        <Link preserveScroll href={route('pegawai.organisasi.index', pegawai.nip)} class="btn btn-dark fw-bolder me-auto px-4 py-3">Kembali</Link>
                    </div>
                </div>
                <div className="card-body py-3">
                    <form onSubmit={submit}>
                        <Input name="nama_organisasi" required={true} values={values.nama_organisasi} onChangeHandle={updateData} />
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Nama organisasi</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <JenisOrganisasi valueHandle={values.jenis_organisasi} onchangeHandle={(e) => changeSelect(e, 'jenis_organisasi')} />
                            </div>
                            {errors.jenis_organisasi && <div className="text-danger">{errors.jenis_organisasi}</div>}
                        </div>
                        <Input name="jabatan" required={false} values={values.jabatan} onChangeHandle={updateData} />
                        <Input name="tanggal_mulai" type='date' required={false} values={values.tanggal_mulai} onChangeHandle={updateData} />
                        <Input name="tanggal_selesai" type='date' required={false} values={values.tanggal_selesai} onChangeHandle={updateData} />
                        <Input name="nama_pimpinan" type='text' required={false} values={values.nama_pimpinan} onChangeHandle={updateData} />
                        <Input name="tempat" type='text' required={false} values={values.tempat} onChangeHandle={updateData} />
                        {/* <div className="row mb-6">
                            <label className="col-lg-3 col-form-label fw-bold fs-6">Unggah Dokumen</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                {
                                    values.file == undefined || values.file == '' ? ''
                                        : <a href={typeof (values.file) == 'object' ? URL.createObjectURL(values.file) : "/storage/" + values.file} className="badge badge-success mb-1 hover:text-gray-200 cursor-pointer" target="_blank">File Saat Ini</a>
                                }
                                <input type="file" accept="application/pdf" name="file" className="form-control p-3 border border-gray-200 rounded" onChange={e => setValues({ ...values, file: e.target.files[0] })} />

                            </div>
                            {errors.file && <div className="text-danger">{errors.file}</div>}
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