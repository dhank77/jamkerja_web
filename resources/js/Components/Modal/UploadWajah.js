import { Inertia } from '@inertiajs/inertia';
import React, { useState } from 'react'
import { Modal, Button, ButtonToolbar } from 'rsuite';

export default function UploadWajah({ nip }) {
    const [open, setOpen] = useState(false);
    const handleOpen = () => setOpen(true);
    const handleClose = () => setOpen(false);
    const [values, setValues] = useState({
        file: '',
    })

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('pegawai.wajah.store', nip), values, {
            onSuccess: () => {
                handleClose();
            }
        })
    }

    return (
        <>
            <ButtonToolbar>
                <button className="btn btn-primary mr-2" onClick={handleOpen}><b>Tambah Wajah</b></button>
            </ButtonToolbar>

            <Modal open={open} onClose={handleClose}>
                <Modal.Header>
                    <Modal.Title>Import Data</Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    <div className="row w-full h-full">
                        <form onSubmit={submit} style={{ height: '400px', }}>
                            <div className="mb-4">
                                <label className="col-lg-12 col-form-label required fw-bold fs-6">Pilih Foto Wajah</label>
                                <div className="col-lg-12 fv-row fv-plugins-icon-container">
                                    {
                                        values.file == undefined || values.file == '' ? "" :
                                        <img src={typeof (values.file) == 'object' ? URL.createObjectURL(values.file) : values.file} className="h-25 w-25 align-self-end" />
                                    }
                                    <input type="file" name="file" className="form-control p-3 border border-gray-200 rounded" onChange={e => setValues({ ...values, file: e.target.files[0] })} />
                                </div>
                            </div>
                            <div className='float-end'>
                                <button type="submit" className='btn btn-success'><b>Upload</b></button>
                            </div>
                        </form>
                        <br /><br />
                    </div>
                </Modal.Body>
                <Modal.Footer>
                    <Button onClick={handleClose} appearance="subtle">
                        Cancel
                    </Button>
                </Modal.Footer>
            </Modal>
        </>
    );
}
