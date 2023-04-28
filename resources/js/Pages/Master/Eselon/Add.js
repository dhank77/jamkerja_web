import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useMemo, useRef, useState } from 'react'
import { Circle, MapContainer, Marker, Popup, TileLayer } from 'react-leaflet';
import { InputNumber, Slider } from 'rsuite';
import "leaflet/dist/leaflet.css";

export default function Add({ errors, eselon }) {

    const [values, setValues] = useState({
        kode_eselon: eselon.kode_eselon,
        nama: eselon.nama,
        kordinat: eselon.kordinat ?? "-4.008427, 119.622869",
        latitude: eselon.latitude,
        longitude: eselon.longitude,
        jarak: eselon.jarak ?? 100,
        id: eselon.id,
    })

    const updateData = (e) => {
        if (e.target.name == 'kordinat') {
            let arr = e.target.value.split(",");
            setValues({ ...values, [e.target.name]: e.target.value, latitude: parseFloat(arr[0].trim()), longitude: parseFloat(arr[1].trim()) })
            setMarkerPosition([parseFloat(arr[0].trim()), parseFloat(arr[1].trim())])
        } else {
            setValues({ ...values, [e.target.name]: e.target.value })
        }
    }

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('master.eselon.store'), values);
    }

    const position = [values.latitude ?? -4.008427, values.longitude ?? 119.622869];
    const [markerPosition, setMarkerPosition] = useState(position)

    const icon = L.icon({
        iconUrl: "/images/vendor/leaflet/dist/marker-icon.png",
        iconSize: [31, 51],
        iconAnchor: [20, 31],
        popupAnchor: [0, -51]
    });

    const markerRef = useRef(null)
    const circleRef = useRef(null)
    const kode_eselonRef = useRef(null)
    const namaRef = useRef(null)
    const eventHandlers = useMemo(
        () => ({
            dragend() {
                const marker = markerRef.current
                const circle = circleRef.current
                const eselon = kode_eselonRef.current.value
                const nama = namaRef.current.value
                if (marker != null) {
                    setMarkerPosition(marker.getLatLng())
                    setValues({
                        ...values,
                        kordinat: marker.getLatLng().lat + ", " + marker.getLatLng().lng,
                        latitude: marker.getLatLng().lat,
                        longitude: marker.getLatLng().lng,
                        jarak: circle.getRadius(),
                        kode_eselon: eselon,
                        nama: nama,
                    })

                }
            },
        }),
        [],
    )

    return (
        <div>
            <div className="toolbar mb-5 mb-lg-7">
                <div className="page-title d-flex flex-column me-3">
                    <h1 className="d-flex text-dark fw-bolder my-1 fs-3">Master</h1>
                    <ul className="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                        <li className="breadcrumb-item text-gray-600">
                            <a href="/" className="text-gray-600 text-hover-primary">Home</a>
                        </li>
                        <li className="breadcrumb-item text-gray-600">Level</li>
                        <li className="breadcrumb-item text-gray-500">Data</li>
                    </ul>
                </div>
                <div className="d-flex align-items-center py-2 py-md-1" >
                    <Link href={route('master.eselon.index')} className="btn btn-dark"><b>Kembali</b></Link>
                </div>
            </div>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Tambah Level</span>
                    </h3>
                </div>
                <div className="card-body py-3">
                    <form onSubmit={submit}>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Kode Level</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="kode_eselon" ref={kode_eselonRef} disabled={values.id != undefined ? true : false} type="number" onChange={updateData} value={values.kode_eselon} className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.kode_eselon && <div className="text-danger">{errors.kode_eselon}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Nama Level</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="nama" ref={namaRef} type="text" onChange={updateData} value={values.nama} className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.nama && <div className="text-danger">{errors.nama}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="form-label">Lokasi Level</label>
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
                                        radius={values.jarak}
                                    />
                                </MapContainer>
                            </div>
                        </div>
                        <div className="row mb-6">
                            <div className="col-sm-12 col-lg-6 mb-4">
                                <label htmlFor="kordinat" className="form-label">Kordinat</label>
                                <input type="text" name="kordinat" id="kordinat" className="mt-1 form-control form-control-lg form-control-solid" onChange={updateData} value={values.kordinat} />
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
                                            value={values.jarak}
                                            onChange={value => {
                                                setValues({ ...values, jarak: value });
                                            }}
                                        />
                                    </div>
                                    <div class="col-3">
                                        <InputNumber
                                            min={100}
                                            max={10000}
                                            value={values.jarak}
                                            onChange={value => {
                                                setValues({ ...values, jarak: value });
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