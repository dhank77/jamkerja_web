import Eselon from '@/Components/Select/Eselon';
import JenisJabatan from '@/Components/Select/JenisJabatan';
import Skpd from '@/Components/Select/Skpd';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useMemo, useRef, useState } from 'react'
import { Circle, MapContainer, Marker, Popup, TileLayer } from 'react-leaflet';
import ReactLeafletGoogleLayer from 'react-leaflet-google-layer';
import { Cascader, InputNumber, Slider } from 'rsuite';
import "leaflet/dist/leaflet.css";
import NumberFormat from 'react-number-format';

export default function Add({ errors, tingkat, parent }) {

    const [values, setValues] = useState({
        nama: tingkat.nama,
        parent_id: tingkat.parent_id,
        kode_tingkat: tingkat.kode_tingkat,
        kode_eselon: tingkat.kode_eselon,
        jenis_jabatan: tingkat.jenis_jabatan,
        kode_skpd: tingkat.kode_skpd,
        gaji_pokok: tingkat.gaji_pokok,
        tunjangan: tingkat.tunjangan,
        id: tingkat.id,
    })

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }
    const updateKordinat = (e) => {
        if (e.target.name == 'kordinat') {
            let arr = e.target.value.split(",");
            if(arr.length > 1 && arr[0] != "" && arr[1] != "" && arr[0] != " " && arr[1] != " "){
                setKordinat({ ...kordinat, [e.target.name]: e.target.value, latitude: parseFloat(arr[0].trim()), longitude: parseFloat(arr[1].trim()) })
                setMarkerPosition([parseFloat(arr[0].trim()), parseFloat(arr[1].trim())])
            }
        } else {
            setKordinat({ ...kordinat, [e.target.name]: e.target.value })
        }
    }


    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('master.tingkat.store'), { values, kordinat });
    }

    const changeSelect = (e, name) => {
        setValues({ ...values, [name]: e[name] })
    }

    const changeData = (value) => {
        setValues({ ...values, parent_id: value })
    }

    const [kordinat, setKordinat] = useState({
        kordinat: tingkat.kordinat,
        latitude: tingkat.latitude,
        longitude: tingkat.longitude,
        jarak: tingkat.jarak ?? 0,
    })

    const position = [kordinat.latitude ?? -4.008427, kordinat.longitude ?? 119.622869];
    const [markerPosition, setMarkerPosition] = useState(position)

    const icon = L.icon({
        iconUrl: "/images/vendor/leaflet/dist/marker-icon.png",
        iconSize: [31, 51],
        iconAnchor: [20, 31],
        popupAnchor: [0, -51]
    });

    const markerRef = useRef(null)
    const circleRef = useRef(null)
    const eventHandlers = useMemo(
        () => ({
            dragend() {
                const marker = markerRef.current
                const circle = circleRef.current
                if (marker != null) {
                    setMarkerPosition(marker.getLatLng())
                    setKordinat({
                        ...kordinat,
                        kordinat: marker.getLatLng().lat + ", " + marker.getLatLng().lng,
                        latitude: marker.getLatLng().lat,
                        longitude: marker.getLatLng().lng,
                        jarak: circle.getRadius(),
                    })

                }
            },
        }),
        [],
    )

    return (
        <div>
            <div className="toolbar mb-5 mb-lg-7 d-flex justify-content-between">
                <div className="page-title d-flex flex-column me-3">
                    <h1 className="d-flex text-dark fw-bolder my-1 fs-3">Master</h1>
                    <ul className="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                        <li className="breadcrumb-item text-gray-600">
                            <a href="/" className="text-gray-600 text-hover-primary">Home</a>
                        </li>
                        <li className="breadcrumb-item text-gray-600">Tingkat</li>
                        <li className="breadcrumb-item text-gray-500">Data</li>
                    </ul>
                </div>
                <div className="d-flex align-items-center py-2 py-md-1" >
                    <Link href={route('master.tingkat.index')} className="btn btn-dark"><b>Kembali</b></Link>
                </div>
            </div>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Tambah Tingkat</span>
                    </h3>
                </div>
                <div className="card-body py-3">
                    <form onSubmit={submit}>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Divisi Kerja</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <Skpd valueHandle={values.kode_skpd} onchangeHandle={(e) => changeSelect(e, 'kode_skpd')} />
                            </div>
                            {errors.kode_skpd && <div className="text-danger">{errors.kode_skpd}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Jenis Jabatan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <JenisJabatan valueHandle={values.jenis_jabatan} onchangeHandle={(e) => changeSelect(e, 'jenis_jabatan')} />
                            </div>
                            {errors.jenis_jabatan && <div className="text-danger">{errors.jenis_jabatan}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label fw-bold fs-6">Jabatan Atasan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <Cascader data={parent} value={values.parent_id} onChange={changeData} parentSelectable style={{ width: '100%' }} />
                            </div>
                            {errors.nama && <div className="text-danger">{errors.nama}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Nama Jabatan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="nama" type="text" onChange={updateData} value={values.nama} className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.nama && <div className="text-danger">{errors.nama}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Level Jabatan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <Eselon valueHandle={values.kode_eselon} onchangeHandle={(e) => changeSelect(e, 'kode_eselon')} />
                            </div>
                            {errors.kode_eselon && <div className="text-danger">{errors.kode_eselon}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label fw-bold fs-6">Gaji Pokok</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <NumberFormat className="form-control" name="gaji_pokok" onChange={updateData} value={values.gaji_pokok} thousandSeparator={'.'} decimalSeparator={','} />
                            </div>
                            {errors.gaji_pokok && <div className="text-danger">{errors.gaji_pokok}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label fw-bold fs-6">Tunjangan Jabatan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <NumberFormat className="form-control" name="tunjangan" onChange={updateData} value={values.tunjangan} thousandSeparator={'.'} decimalSeparator={','} />
                            </div>
                            {errors.tunjangan && <div className="text-danger">{errors.tunjangan}</div>}
                        </div>
                        <hr />
                        <div className='alert alert-danger'>Lokasi Tidak Wajib ditentukan, Akan tetapi jika di tentukan maka berdasarkan prioritas mulai dari lokasi per pegawai, jabatan, level jabatan, divisi kerja dan terakhir lokasi kerja, jadi jika kordinat kosong di data pegawai akan mencari ke jabatan, jika jabatan kosong akan mencari ke level jabatan, jika di level jabatan kosong akan mencari ke divisi kerja dan jika semuanya kosong maka akan mencari data lokasi kerja dan jika lokasi kerja kosong maka presensi tidak bisa dilakukan </div>
                        <div className="row mb-6">
                            <label className="form-label">Lokasi</label>
                            <div>
                                <MapContainer center={position} zoom={5} scrollWheelZoom={false} style={{ height: "600px", width: "100%" }}>
                                    <ReactLeafletGoogleLayer apiKey='AIzaSyA1MgLuZuyqR_OGY3ob3M52N46TDBRI_9k' type={'roadmap'} />
                                    <Marker
                                        position={markerPosition}
                                        icon={icon}
                                        draggable={true}
                                        eventHandlers={eventHandlers}
                                        ref={markerRef}
                                    >
                                        <Popup>
                                            Sesuaikan Titik Yang diinginkan.
                                        </Popup>
                                    </Marker>
                                    <Circle
                                        ref={circleRef}
                                        center={markerPosition}
                                        pathOptions={{ color: 'red', fillColor: 'red' }}
                                        radius={kordinat.jarak}
                                    />
                                </MapContainer>
                            </div>
                        </div>
                        <div className="row mb-6">
                            <div className="col-sm-12 col-lg-6 mb-4">
                                <label htmlFor="kordinat" className="form-label">Kordinat</label>
                                <input type="text" name="kordinat" id="kordinat" className="mt-1 form-control form-control-lg form-control-solid" onChange={updateKordinat} value={kordinat.kordinat} />
                            </div>
                            <div className="col-sm-12 col-lg-6 mb-4">
                                <label className="form-label">Jarak Wilayah (m)</label>
                                <div class="row">
                                    <div class="col-9">
                                        <Slider
                                            min={100}
                                            max={10000}
                                            progress
                                            style={{ marginTop: 16 }}
                                            value={kordinat.jarak}
                                            onChange={value => {
                                                setKordinat({ ...kordinat, jarak: value });
                                            }}
                                        />
                                    </div>
                                    <div class="col-3">
                                        <InputNumber
                                            min={100}
                                            max={10000}
                                            value={kordinat.jarak}
                                            onChange={value => {
                                                setKordinat({ ...kordinat, jarak: value });
                                            }}
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="float-right">
                            <button type="submit" className="btn btn-primary">Simpan</button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    )
}

Add.layout = (page) => <Authenticated children={page} />