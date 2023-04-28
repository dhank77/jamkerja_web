import { Inertia } from '@inertiajs/inertia';
import React, { useEffect, useState } from 'react'
import { usePrevious } from 'react-use';

export default function Search() {

    const [query, setQuery] = useState({
        s : '',
        limit : 10,
    });
    const prev = usePrevious(query);

    useEffect(() => {
        if(prev){
            Inertia.get(route(route().current(), { _query : route().params }), query, {
                replace: true,
                preserveState: true,
            })
        }
    }, [query])

    return (
        <div className="flex align-items-center justify-content-between z-0">
            <div className='w-20'>
                <select name="show" id="show" className="form-control" value={query.limit} onChange={(e) => setQuery({ ...query, limit: e.target.value })}>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
            <div className='w-64'>
                <input onChange={(e) => setQuery({ ...query, s: e.target.value })} value={query.s} type="text" className="form-control rounded focus:outline-none border border-gray-500" placeholder="Cari..." />
            </div>
        </div>
    )
}
