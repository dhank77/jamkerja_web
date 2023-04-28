import Input from '@/Components/Crud/Input';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useState } from 'react'
import Detail from '../Pegawai/Detail';

export default function Add({ errors, pegawai, Rlembur }) {

    const [values, setValues] = useState({
        tanggal: Rlembur.tanggal,
        jam_mulai: Rlembur.jam_mulai,
        jam_selesai: Rlembur.jam_selesai,
        tanggal_surat: Rlembur.tanggal_surat,
        nomor_surat: Rlembur.nomor_surat,
        keterangan: Rlembur.keterangan,
        file: Rlembur.file,
        id: Rlembur.id,
    });

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('pegawai.lembur.store', pegawai.nip), values);
    }

    return (
        <Detail pegawai={pegawai}>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Tambah Riwayat lembur</span>
                    </h3>
                    <div class="card-toolbar">
                        <Link preserveScroll href={route('pegawai.lembur.index', pegawai.nip)} class="btn btn-dark fw-bolder me-auto px-4 py-3">Kembali</Link>
                    </div>
                </div>
                <div className="card-body py-3">
                    <form onSubmit={submit}>
                        <Input name="tanggal" type='date' required={true} values={values.tanggal} onChangeHandle={updateData} />
                        <Input name="jam_mulai" type='time' required={true} values={values.jam_mulai} onChangeHandle={updateData} />
                        <Input name="jam_selesai" type='time' required={true} values={values.jam_selesai} onChangeHandle={updateData} />
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