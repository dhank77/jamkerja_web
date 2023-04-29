import React, { useEffect, useState } from 'react'
import Select from 'react-select'

export default function Skpd({ onchangeHandle, valueHandle, className='' }) {

  const [data, setData] = useState([])

  useEffect(() => {
    loadData();
  }, [])

  const loadData = async () => {
    try {
      let { data } = await axios.get(route('master.skpd.json'));
      setData(data);
    } catch (error) {
      console.log(error);
    }
  }


  return (
    <Select options={data} className={className == '' ? 'z-50' : className} onChange={onchangeHandle} value={data.filter(obj => (obj.kode_skpd == valueHandle))} />
  )
}
