import Input from '@/Components/Crud/Input';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useEffect, useState } from 'react'
import Detail from '../Pegawai/Detail';
import Pendidikan from '@/Components/Select/Pendidikan';
import Select from 'react-select';

export default function Add({ errors, pegawai, Rpendidikan }) {

    const [values, setValues] = useState({
        kode_pendidikan: Rpendidikan.kode_pendidikan,
        kode_jurusan: Rpendidikan.kode_jurusan,
        nomor_ijazah: Rpendidikan.nomor_ijazah,
        tanggal_lulus: Rpendidikan.tanggal_lulus,
        nama_sekolah: Rpendidikan.nama_sekolah,
        gelar_depan: Rpendidikan.gelar_depan,
        tanggal_bkn: Rpendidikan.tanggal_bkn,
        masa_tahun: Rpendidikan.masa_tahun,
        masa_bulan: Rpendidikan.masa_bulan,
        file: Rpendidikan.file,
        is_akhir: Rpendidikan.is_akhir,
        id: Rpendidikan.id,
    });

    const [jurusan, setJurusan] = useState([]);

    useEffect(() => {
        if (values.kode_pendidikan != undefined) {
            getJurusan(values.kode_pendidikan);
        }
    }, [values.kode_pendidikan])

    const getJurusan = async (id) => {
        try {
            let { data } = await axios.get(route('master.jurusan.json', id));
            setJurusan(data);
        } catch (error) {
            console.log(error);
        }
    }

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    const changeSelect = (e, name) => {
        setValues({ ...values, [name]: e[name] })
    }

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('pegawai.pendidikan.store', pegawai.nip), values);
    }

    return (
        <Detail pegawai={pegawai}>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Tambah Riwayat pendidikan</span>
                    </h3>
                    <div class="card-toolbar">
                        <Link preserveScroll href={route('pegawai.pendidikan.index', pegawai.nip)} class="btn btn-dark fw-bolder me-auto px-4 py-3">Kembali</Link>
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
                                        Pendidikan Akhir
                                    </label>
                                </div>
                                <div class="form-check form-check-custom form-check-success form-check-solid form-check-lg">
                                    <input class="form-check-input" checked={values.is_akhir == 0 ? true : false} onChange={updateData} name='is_akhir' type="radio" value="0" id="flexCheckbox2" />
                                    <label class="form-check-label" for="flexCheckbox2">
                                        Riwayat pendidikan
                                    </label>
                                </div>
                            </div>
                            {errors.is_akhir && <div className="text-danger">{errors.is_akhir}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Tingkat Pendidikan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <Pendidikan valueHandle={values.kode_pendidikan} onchangeHandle={(e) => changeSelect(e, 'kode_pendidikan')} />
                            </div>
                            {errors.kode_pendidikan && <div className="text-danger">{errors.kode_pendidikan}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Jurusan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <Select value={jurusan.filter(obj => (obj.kode_jurusan == values.kode_jurusan))} options={jurusan} onChange={(e) => changeSelect(e, 'kode_jurusan')} />
                            </div>
                            {errors.kode_jurusan && <div className="text-danger">{errors.kode_jabatan}</div>}
                        </div>
                        <Input name="nomor_ijazah" required={true} values={values.nomor_ijazah} onChangeHandle={updateData} />
                        <Input name="tanggal_lulus" type='date' required={true} values={values.tanggal_lulus} onChangeHandle={updateData} />
                        <div className="row mb-6">
                            <label className={`col-lg-3 col-form-label fw-bold fs-6 text-capitalize required`}>Nama Sekolah / Perguruan Tinggi</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="nama_sekolah" required={true}
                                    onChange={updateData} value={values.nama_sekolah} className="form-control form-control-lg form-control-solid" placeholder="Nama Sekolah / Perguruan Tinggi" />
                            </div>
                            {errors.nama_sekolah && <div className="text-danger">{errors.nama_sekolah}</div>}
                        </div>
                        <Input name="gelar_depan" type='text' required={false} values={values.gelar_depan} onChangeHandle={updateData} />
                        <Input name="gelar_belakang" type='text' required={false} values={values.gelar_belakang} onChangeHandle={updateData} />
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