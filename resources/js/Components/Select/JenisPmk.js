import React from 'react'
import Select from 'react-select'

export default function JenisPmk({ onchangeHandle, valueHandle }) {

    const options = [
        { value : 'negeri', jenis_pmk: 'negeri', label: 'Negeri' },
        { value : 'swasta', jenis_pmk: 'swasta', label: 'Swasta' },
    ]

  return (
    <Select options={options} onChange={onchangeHandle} value={options.filter(obj => (obj.jenis_pmk == valueHandle))} />
  )
}
