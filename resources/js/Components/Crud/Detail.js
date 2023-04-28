import { Link } from '@inertiajs/inertia-react'
import React from 'react'

export default function Detail({ routes }) {
    return (
        <div className="dropdown-item menu-item px-3">
            <Link href={routes} className="menu-link px-3"><i className='fa fa-book mr-2 text-success'></i> Detail </Link>
        </div>
    )
}
