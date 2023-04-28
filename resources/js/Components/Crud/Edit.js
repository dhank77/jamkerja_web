import { Link } from '@inertiajs/inertia-react'
import React from 'react'

export default function Edit({ routes }) {
    return (
        <div className="dropdown-item menu-item px-3">
            <Link href={routes} className="menu-link px-3"><i className='fa fa-edit mr-2 text-primary'></i> Ubah </Link>
        </div>
    )
}
