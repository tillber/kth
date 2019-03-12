# foldp.ex
defmodule Fold do
  def foldp([x], _op) do x end
  def foldp(list, op) do
    half = round(length(list) / 2)
    {left, right} = Enum.split(list, half)

    parent = self()
    l = spawn(fn -> send(parent, {:res, foldp(left, op)}) end)
    r = spawn(fn -> send(parent, {:res, foldp(right, op)}) end)

    receive do
      {:res, resl} ->
        receive do
          {:res, resr} ->
            op.(resl, resr)
        end
    end
  end
end
