import { Link } from '@inertiajs/inertia-react'
import React from 'react'

export default function Paginate({meta }) {
    return (
        <div className='flex justify-between'>
            <div>
                {meta.links && meta.links.map((page, key) => (
                    <Link key={key} as="button" disabled={page.url === null ? true : false } className={`badge badge-primary mr-1 text-lg px-3 py-2 ${page.url === null && 'text-gray-700'} ${page.active && 'badge badge-dark'}`} href={`${page.url}`} dangerouslySetInnerHTML={{ __html: page.label }} preserveState preserveScroll/>
                ))}
            </div>
            <div className='badge badge-primary'>
                Total Data : { meta.total }
            </div>
        </div>
    )
}
