import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/inertia-react';
import React, { useState } from 'react'
import { Modal, Button, ButtonToolbar } from 'rsuite';
import Swal from 'sweetalert2';
import Month from '../Date/Month';
import Year from '../Date/Year';


export default function Import({ route, format }) {
    const [open, setOpen] = useState(false);
    const handleOpen = () => setOpen(true);
    const handleClose = () => setOpen(false);
    const [values, setValues] = useState({
        file: '',
        bulan: '',
        tahun: '',
    })

    const filterBulan = (e) => setValues({ ...values, bulan: e.value });
    const filterTahun = (e) => setValues({ ...values, tahun: e.value });

    const { errors } = usePage().props;
    const submit = (e) => {
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Mohon tunggu!',
            text: 'Proses Import data sedang berlangsung!',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showCancelButton: false,
            showConfirmButton: false
        })
        Inertia.post(route, values);
    }

    console.log(values);

    return (
        <>
            <ButtonToolbar>
                <button className="btn btn-primary mr-2" onClick={handleOpen}><b>Import</b></button>
            </ButtonToolbar>

            <Modal open={open} onClose={handleClose}>
                <Modal.Header>
                    <Modal.Title>Import Data</Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    <div className="row" style={{ width: "100%", height: "400px" }}>
                        <form onSubmit={submit}>
                            <div className="mb-4">
                                <label className="col-lg-12 col-form-label required fw-bold fs-6">Pilih File</label>
                                <div className="col-lg-12 fv-row fv-plugins-icon-container">
                                    {
                                        values.file == undefined || values.file == '' ? ''
                                            : <a href={typeof (values.file) == 'object' ? URL.createObjectURL(values.file) : values.file} className="badge badge-success mb-1 hover:text-gray-200 cursor-pointer" target="_blank">File Saat Ini</a>
                                    }
                                    <input type="file" name="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" className="form-control p-3 border border-gray-200 rounded" onChange={e => setValues({ ...values, file: e.target.files[0] })} />
                                    {errors.file && <div className="text-danger">{errors.file}</div>}
                                </div>
                                <div className='mt-2'>
                                    <a href={format} className='badge badge-success text-white'>Download Format Import</a>
                                </div>
                            </div>
                            <div className="mb-4">
                                <label className="col-lg-12 col-form-label required fw-bold fs-6">Bulan</label>
                                <div className="col-lg-12 fv-row fv-plugins-icon-container">
                                    <Month filterBulan={filterBulan} />
                                </div>
                            </div>
                            <div className="mb-4">
                                <label className="col-lg-12 col-form-label required fw-bold fs-6">Tahun</label>
                                <div className="col-lg-12 fv-row fv-plugins-icon-container">
                                    <Year filterTahun={filterTahun} />
                                </div>
                            </div>
                            <div className='float-end'>
                                <button type="submit" className='btn btn-success'><b>Import</b></button>
                            </div>
                        </form>
                        <br /><br />
                    </div>
                </Modal.Body>
                <Modal.Footer>
                    <Button onClick={handleClose} appearance="primary">
                        Ok
                    </Button>
                    <Button onClick={handleClose} appearance="subtle">
                        Cancel
                    </Button>
                </Modal.Footer>
            </Modal>
        </>
    );
}
