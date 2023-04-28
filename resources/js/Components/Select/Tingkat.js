import React, { useEffect, useState } from 'react'
import { Cascader } from 'rsuite';

export default function Tingkat({ skpd, onchangeHandle, valueHandle }) {

  const [data, setData] = useState([])

  useEffect(() => {
    loadData();
  }, [skpd])

  const loadData = async () => {
    try {
      let { data } = await axios.get(route('master.tingkat.json', {skpd : skpd}));
      setData(data);
    } catch (error) {
      console.log(error);
    }
  }


  return (
    <Cascader data={data} parentSelectable style={{ width: '100%' }} className="z-20" onChange={onchangeHandle} value={valueHandle} />
  )
}
