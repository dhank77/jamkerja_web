import React from 'react'
import Select from 'react-select';

export default function Year({filterTahun, name='tahun', value='', selectedTahun = null }) {

    const tahunSekarang = new Date().getFullYear();

    let tahun = []
    for (let index = tahunSekarang + 1; index >= 1970 ; index--) {
        tahun.push({
            value: index,
            label: 'Tahun ' + index
        })
    }

    return (
        <div  className="mb-1">
            <Select options={tahun} name={name} onChange={filterTahun} className="w-full" defaultValue={ selectedTahun ? tahun[tahunSekarang - selectedTahun] : ( value != '' ? tahun[tahunSekarang-value] : tahun[1])} />
        </div>
    )
}
