import Shift from '@/Components/Select/Shift';
import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useMemo, useRef, useState } from 'react'
import { Circle, MapContainer, Marker, Popup, TileLayer } from 'react-leaflet';
import { Cascader, InputNumber, Slider } from 'rsuite';
import "leaflet/dist/leaflet.css";
import JenisLokasi from '@/Components/Select/JenisLokasi';
import Pegawai from '@/Components/Select/Pegawai';
import Skpd from '@/Components/Select/Skpd';

export default function Add({ errors, lokasi, parent, lokasiDetail }) {

    const [keterangan, setKeterangan] = useState(lokasiDetail ?? [])
    const [values, setValues] = useState({
        kode_lokasi: lokasi.kode_lokasi,
        kode_shift: lokasi.kode_shift,
        nama: lokasi.nama,
        keterangan: lokasi.keterangan,
        id: lokasi.id,
    })

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    const updateKordinat = (e) => {
        if (e.target.name == 'kordinat') {
            let arr = e.target.value.split(",");
            setKordinat({ ...kordinat, [e.target.name]: e.target.value, latitude: parseFloat(arr[0].trim()), longitude: parseFloat(arr[1].trim()) })
            setMarkerPosition([parseFloat(arr[0].trim()), parseFloat(arr[1].trim())])
        } else {
            setKordinat({ ...kordinat, [e.target.name]: e.target.value })
        }
    }

    const changeSelect = (e, name) => {
        setValues({ ...values, [name]: e[name] })
    }
    const changeKeterangan = (e) => {
        setKeterangan(e)
    };


    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('master.lokasi.store'), { values, keterangan, kordinat });
    }

    const [kordinat, setKordinat] = useState({
        kordinat: lokasi.kordinat,
        latitude: lokasi.latitude,
        longitude: lokasi.longitude,
        jarak: lokasi.jarak ?? 0,
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
                        <li className="breadcrumb-item text-gray-600">lokasi</li>
                        <li className="breadcrumb-item text-gray-500">Data</li>
                    </ul>
                </div>
                <div className="d-flex align-items-center py-2 py-md-1" >
                    <Link href={route('master.lokasi.index')} className="btn btn-dark"><b>Kembali</b></Link>
                </div>
            </div>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Tambah lokasi</span>
                    </h3>
                </div>
                <div className="card-body py-3">
                    <form onSubmit={submit}>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Nama lokasi</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="nama" type="text" onChange={updateData} value={values.nama} className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.nama && <div className="text-danger">{errors.nama}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Shift</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <Shift valueHandle={values.kode_shift} onchangeHandle={(e) => changeSelect(e, 'kode_shift')} />
                            </div>
                            {errors.kode_shift && <div className="text-danger">{errors.kode_shift}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Keterangan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <JenisLokasi valueHandle={values.keterangan} onchangeHandle={(e) => changeSelect(e, 'keterangan')} />
                            </div>
                            {errors.keterangan && <div className="text-danger">{errors.keterangan}</div>}
                        </div>
                        {
                            values.keterangan == '1' &&
                            <div className="row mb-6">
                                <label className="col-lg-3 col-form-label required fw-bold fs-6">Pilih Pegawai</label>
                                <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                    <Pegawai valueHandle={keterangan} onchangeHandle={(e) => changeKeterangan(e)} />
                                </div>
                                {errors.keterangan && <div className="text-danger">{errors.keterangan}</div>}
                            </div>
                        }
                        {
                            values.keterangan == '2' &&
                            <div className="row mb-6">
                                <label className="col-lg-3 col-form-label required fw-bold fs-6">Pilih Jabatan</label>
                                <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                    <Cascader data={parent} value={keterangan} onChange={changeKeterangan} parentSelectable style={{ width: '100%' }} />
                                </div>
                                {errors.keterangan && <div className="text-danger">{errors.keterangan}</div>}
                            </div>
                        }
                        {
                            values.keterangan == '3' &&
                            <div className="row mb-6">
                                <label className="col-lg-3 col-form-label required fw-bold fs-6">Pilih Berdasarkan Divisi</label>
                                <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                    <Skpd valueHandle={keterangan.kode_skpd} onchangeHandle={(e) => changeKeterangan(e)} />
                                </div>
                                {errors.keterangan && <div className="text-danger">{errors.keterangan}</div>}
                            </div>
                        }
                        <hr />
                        <div className='alert alert-danger'>Lokasi Tidak Wajib ditentukan, Akan tetapi jika di tentukan maka menjadi pilihan terakhir dengan pentuan lokasi prioritas mulai dari lokasi per pegawai, jabatan, level jabatan, divisi kerja dan terakhir lokasi kerja, jadi jika kordinat kosong di data pegawai akan mencari ke jabatan, jika jabatan kosong akan mencari ke level jabatan, jika di level jabatan kosong akan mencari ke divisi kerja dan jika semuanya kosong maka akan mencari data lokasi kerja dan jika lokasi kerja kosong maka presensi tidak bisa dilakukan </div>
                        <div className="row mb-6">
                            <label className="form-label">Lokasi</label>
                            <div>
                                <MapContainer center={position} zoom={13} scrollWheelZoom={false} style={{ height: "600px", width: "100%" }}>
                                    <TileLayer
                                        attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                                        url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                                    />
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