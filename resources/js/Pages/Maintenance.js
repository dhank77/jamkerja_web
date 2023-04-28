import React from 'react';
import Authenticated from '@/Layouts/Authenticated';

export default function Maintenance(props) {
    return (
        <div className="content flex-column-fluid" id="kt_content">
            <div className="row gy-5 g-xl-10">
                <div className="col-sm-12 col-xl-12 mb-xl-10">
                    <div className="card h-lg-100">
                        <div className="card-body d-flex justify-content-between align-items-start flex-column">
                            <h1 className='text-danger'>Sistem Sedang Dalam Perbaikan!</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

Maintenance.layout = (page) => <Authenticated children={page} />
