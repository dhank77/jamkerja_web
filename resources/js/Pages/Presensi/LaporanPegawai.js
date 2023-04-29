import React, { useEffect, useState } from 'react'
import Authenticated from '@/Layouts/Authenticated'
import Select from 'react-select'
import Month from '@/Components/Date/Month'
import Year from '@/Components/Date/Year'
import { usePage } from '@inertiajs/inertia-react'
import Skpd from '@/Components/Select/Skpd'

export default function LaporanPegawai() {

    const { auth } = usePage().props;

    const [pegawai, setPegawai] = useState([])


    const [data, setData] = useState({
        kode_skpd: auth.user.jabatan_akhir[0]?.kode_skpd,
        nip: '',
        bulan: '',
        tahun: '',
    })

    const pdfDownload = () => {
        if (data.nip == '') {
            toast.error('Unit Kerja Wajib dipilih!')
        } else {
            window.open(`/pengajuan/presensi/laporan-pegawai-download?nip=${data.nip}&bulan=${data.bulan}&tahun=${data.tahun}`, '_blank', 'noopener,noreferrer')
        }
    }
    const xlsDownload = () => {
        if (data.nip == '') {
            toast.error('Unit Kerja Wajib dipilih!')
        } else {
            window.open(`/pengajuan/presensi/laporan-pegawai-download?nip=${data.nip}&bulan=${data.bulan}&tahun=${data.tahun}&xl=1`, '_blank', 'noopener,noreferrer')
        }
    }
    const changeSelect = (e, name) => setData({ ...data, [name] : e[name] });
    const filterBulan = (e) => setData({ ...data, bulan: e.value });
    const filterTahun = (e) => setData({ ...data, tahun: e.value });

    const changePegawai = (e) => {
        setData({ ...data, nip: e.value })
    }

    const getPegawai = async () => {
        try {
            let res = await axios.get(route('pegawai.pegawai.json_skpd', {skpd : data.kode_skpd}));
            setPegawai(res.data);
        } catch (error) {
            console.log(error);
        }
    }

    useEffect(() => {
        if (data.kode_skpd != undefined && data.kode_skpd != "") {
            getPegawai()
        }
    }, [data.kode_skpd])

    return (
        <div>
            <div className="toolbar mb-5 mb-lg-7 d-flex justify-content-between">
                <div className="page-title d-flex flex-column me-3">
                    <h1 className="d-flex text-dark fw-bolder my-1 fs-3">Presensi</h1>
                    <ul className="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                        <li className="breadcrumb-item text-gray-600">
                            <a href="/" className="text-gray-600 text-hover-primary">Home</a>
                        </li>
                        <li className="breadcrumb-item text-gray-600">Laporan</li>
                        <li className="breadcrumb-item text-gray-600">Pegawai</li>
                    </ul>
                </div>
            </div>
            <div className="content">
                <div className="card mb-5 mb-xl-8">
                    <div className="card-header border-0 pt-5">
                        <h3 className="card-title align-items-start flex-column">
                            <span className="card-label fw-bolder fs-3 mb-1">Download Laporan Pegawai</span>
                        </h3>
                    </div>
                    <div className="card-body py-3">
                        <form>
                            <div className="px-4 py-5">
                                {
                                    auth.role.some(ar => ['admin', 'owner'].includes(ar))  &&
                                        <div className="mb-4">
                                            <label className='form-label'>Pilih Divisi Kerja</label>
                                            <Skpd valueHandle={data.kode_skpd} onchangeHandle={(e) => changeSelect(e, 'kode_skpd')} />
                                        </div> 
                                }
                                <div className="col-lg-12 mb-4">
                                    <label className="form-label">Pilih Pegawai</label>
                                    <Select onChange={changePegawai} value={pegawai.filter(obj => (obj.value == data.nip))} options={pegawai} className="w-full" />
                                </div>
                                <div className="mb-4">
                                    <label className="form-label">Pilih Bulan</label>
                                    <Month filterBulan={filterBulan} />
                                </div>
                                <div className="mb-4">
                                    <label className="form-label">Pilih Tahun</label>
                                    <Year filterTahun={filterTahun} />
                                </div>


                            </div>
                            <div className="d-flex justify-content-end">
                                <button onClick={xlsDownload} type="button" className="btn btn-success mr-2">
                                    Download Excel
                                </button>
                                <button onClick={pdfDownload} type="button" className="btn btn-danger">
                                    Download PDF
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    )
}

LaporanPegawai.layout = (page) => <Authenticated children={page} />