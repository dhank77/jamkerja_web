import { Inertia } from '@inertiajs/inertia';
import React, { useEffect, useState } from 'react'
import Select from 'react-select';
import { usePrevious } from 'react-use';

export default function YearSelect({ name='tahun', value='', selectedTahun = null }) {

    const tahunSekarang = new Date().getFullYear();

    let tahun = []
    for (let index = tahunSekarang + 1; index >= 1970 ; index--) {
        tahun.push({
            value: index,
            label: 'Tahun ' + index
        })
    }

    const [query, setQuery] = useState({
        tahun : ''
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

    const filterTahun = (e) => setQuery({...query, tahun : e.value })

    return (
        <div  className="mb-1">
            <Select options={tahun} name={name} onChange={filterTahun} className="w-full" defaultValue={ selectedTahun ? tahun[tahunSekarang - selectedTahun] : ( value != '' ? tahun[tahunSekarang-value] : tahun[1])} />
        </div>
    )
}
