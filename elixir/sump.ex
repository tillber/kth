# sump.ex
defmodule Sump do
  @type tree :: {:node, integer(), tree(), tree()} | nil
  @spec sum(tree()) :: integer()

  def sum(nil) do 0 end
  def sum({:node, value, left, right}) do
    parent = self()
    spawn(fn -> send(parent, {:result, sum(left)}) end)
    spawn(fn -> send(parent, {:result, sum(right)}) end)

    receive do
      {:result, x} ->
        receive do
          {:result, y} ->
            value + x + y
        end
      end
  end
end

#HELLO WORLD
