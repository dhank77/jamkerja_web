import axios from 'axios'
import React, { useState } from 'react'
import { Button, Modal } from 'rsuite'

export default function Logs({ model_type, model_id }) {

    const [data, setData] = useState([])
    const [open, setOpen] = useState(false);
    const handleOpen = async () => {
        setOpen(true);
        let res = await axios.get(route('logs', { model_type: model_type, model_id: model_id }));
        setData(res.data);
    };
    const handleClose = () => setOpen(false);

    return (
        <>
            <Modal open={open} onClose={handleClose}>
                <Modal.Header>
                    <Modal.Title><span className="text-lg font-semibold">Log Perubahan Data </span></Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    {
                        data && data.map((d, k) => (
                            <div key={k} className="notice d-flex bg-light-primary rounded border-primary border border-dashed w-full flex-shrink-0 p-6 mb-2">
                                <span className="svg-icon svg-icon-2tx svg-icon-primary me-4">
                                    <img src={d.foto == "" ? "/assets/media/avatars/blank.png" : d.foto} alt="img" className="w-16 h-16 rounded" />
                                </span>
                                <div className="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                                    <div className="mb-3 mb-md-0 fw-bold">
                                        <h6 className="text-danger font-semibold">{d.action.toUpperCase()}</h6>
                                        <h6 className="text-gray-900 fw-bolder">Oleh : {d.user}</h6>
                                    </div>
                                    <a href="#" className="btn btn-primary px-6 align-self-center text-nowrap">{d.tanggal}</a>
                                </div>
                            </div>
                        ))
                    }
                </Modal.Body>
                <Modal.Footer>
                    <Button onClick={handleClose} appearance="primary">
                        Cancel
                    </Button>
                </Modal.Footer>
            </Modal>
            <div className="dropdown-item  menu-item px-3">
                <a href='#' onClick={handleOpen} className="menu-link px-3">
                    <i className='fa fa-book mr-2 text-warning'></i> Logs </a>
            </div>
        </>
    )
}
