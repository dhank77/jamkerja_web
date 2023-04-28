import React from 'react'
import Select from 'react-select'

export default function Keluarga({ onchangeHandle, valueHandle, tambah = '' }) {
  
  let optionsK;
  if (tambah == 'orang-tua') {
    optionsK = [
      { value: 'ayah', status: 'ayah', label: 'Ayah' },
      { value: 'ibu', status: 'ibu', label: 'Ibu' },
    ]
  } else {
    optionsK = [
      { value: 'ayah', status: 'ayah', label: 'Ayah' },
      { value: 'ibu', status: 'ibu', label: 'Ibu' },
      { value: 'suami/istri', status: 'suami/istri', label: 'Suami / Istri' },
      { value: 'anak', status: 'anak', label: 'Anak' },
    ]
  }

  return (
    <Select options={optionsK} onChange={onchangeHandle} value={optionsK.filter(obj => (obj.status == valueHandle))} />
  )
}
