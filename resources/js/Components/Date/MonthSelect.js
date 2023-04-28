import { Inertia } from '@inertiajs/inertia';
import React, { useEffect, useState } from 'react'
import Select from 'react-select';
import { usePrevious } from 'react-use';

export default function MonthSelect({ value = null, name='bulan', selectedBulan=null }) {

    const bulanSekarang = new Date().getMonth();

    const namaBulan = (bulan) => {
        switch(bulan) {
            case 1: return "Januari"; break;
            case 2: return "Februari"; break;
            case 3: return "Maret"; break;
            case 4: return "April"; break;
            case 5: return "Mei"; break;
            case 6: return "Juni"; break;
            case 7: return "Juli"; break;
            case 8: return "Agustus"; break;
            case 9: return "September"; break;
            case 10: return "Oktober"; break;
            case 11: return "November"; break;
            case 12: return "Desember"; break;
        }
    }

    let bulan = []
    for (let index = 1; index <= 12 ; index++) {
        bulan.push({
            value: index,
            label: namaBulan(index)
        })
    }

    const [query, setQuery] = useState({
        bulan : ''
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

    const filterBulan = (e) => setQuery({...query, bulan : e.value })

    return (
        <div className="mb-1 mr-2">
            <Select options={bulan} name={name} onChange={filterBulan} className="w-full" defaultValue={ selectedBulan ? bulan[selectedBulan - 1] :  (value ? bulan[value-1] : bulan[bulanSekarang])} />
        </div>
    )
}
