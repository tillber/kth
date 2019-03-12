# sump.ex
defmodule Sum do
  @type tree :: nil | {:node, integer(), tree(), tree()}
  @spec sum(tree) :: integer()

  def sum(nil) do 0 end
  def sum({:node, value, left, right}) do
    parent = self()
    spawn(fn -> send(parent, {:result, sum(left)}) end)
    spawn(fn -> send(parent, {:result, sum(right)}) end)

    receive do
      {:result, resl} ->
        receive do
          {:result, resr} ->
            resl + value + resr
        end
    end
  end
end
